<?php

namespace Prestabarr\Listeners;

use Prestabarr\Events\PrestashopToDolibarOrderEvent;
use Prestabarr\Events\PrestashopToDolibarUpdateProductEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Prestabarr\Models\Dolibarr\DolibarrBankModel;
use Prestabarr\Models\Dolibarr\DolibarrCommandeDetModel;
use Prestabarr\Models\Dolibarr\DolibarrCommandeModel;
use Prestabarr\Models\Dolibarr\DolibarrFactureDetModel;
use Prestabarr\Models\Dolibarr\DolibarrFactureModel;
use Prestabarr\Models\Dolibarr\DolibarrProductModel;
use Prestabarr\Models\Dolibarr\DolibarrSocieteModel;
use Prestabarr\Models\Dolibarr\DolibarrSocPeopleModel;
use Prestabarr\Models\Prestashop\PrestashopAddressModel;
use Prestabarr\Models\Prestashop\PrestashopCartRuleModel;
use Prestabarr\Models\Prestashop\PrestashopOrderCartRuleModel;
use Prestabarr\Models\Prestashop\PrestashopCustomerModel;
use Prestabarr\Models\Prestashop\PrestashopOrderDetailModel;
use Prestabarr\Models\Prestashop\PrestashopOrdersModel;

class PrestashopToDolibarOrder implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object $event
     * @return void
     */
    public function handle(PrestashopToDolibarOrderEvent $event)
    {
        $prestashopOrder = PrestashopOrdersModel::where('reference', $event->ref)->first();

        if ($prestashopOrder) {
            $prestashopCustomer = PrestashopCustomerModel::where('id_customer', $prestashopOrder->id_customer)->first();
            $prestashopAddress = PrestashopAddressModel::where('id_address', $prestashopOrder->id_address_delivery)->first();
            $prestashopOrderDetail = PrestashopOrderDetailModel::where('id_order', $prestashopOrder->id_order)->get();

            $dolibarrSociete = DolibarrSocieteModel::where('email', $prestashopCustomer->email)->first();
            $dolibarrSocPeople = DolibarrSocPeopleModel::where('email', $prestashopCustomer->email)->first();

            if (!$dolibarrSociete) {
                $dolibarrSociete = $this->createDolibarrSociete($prestashopCustomer, $prestashopAddress);
            }

            if (!$dolibarrSocPeople) {
                $dolibarrSocPeople = $this->createDolibarrSocPeople($dolibarrSociete, $prestashopCustomer, $prestashopAddress);
            }

            $dolibarrCommande = $this->createNewCommande($dolibarrSociete, $prestashopOrder);
            $dolibarrFacture = $this->createDolibarrFacture($dolibarrSociete, $prestashopOrder);

            foreach ($prestashopOrderDetail as $lineOfOrder) {
                $dolibarrProduct = DolibarrProductModel::where('ref', $lineOfOrder->product_reference)->first();

                if ($dolibarrProduct) {
                    $this->createDolibarrCommandeDet($lineOfOrder, $dolibarrCommande, $dolibarrProduct);
                    $this->createDolibarrFactureDet($dolibarrFacture, $dolibarrProduct, $lineOfOrder);
                    event(new PrestashopToDolibarUpdateProductEvent($dolibarrProduct->ref, $dolibarrProduct->price));
                } else {
                    \Log::error('Error al actualizar linea de producto en pedido. product_reference='.$lineOfOrder->product_reference.' order_prestashop_reference='.$event->ref);
                }
            }

            $this->createDolibarrBank($dolibarrCommande);

        } else {
            \Log::error('[PrestashopToDolibarOrder] Error al grabar compra online. Referencia: '.$event->ref);
        }
    }

    private function getLastCodeClient()
    {
        $code = 'CU'.date('ym').'-';
        $societe = DolibarrSocieteModel::where('code_client','like',$code.'%')->orderBy('datec', 'desc')->first();

        if ($societe) {
            $number = ((int)str_replace($code,'',$societe->code_client))+1;
            $code = $code.str_pad($number, 4, '0', STR_PAD_LEFT);

        } else {
            $code = $code.'0001';
        }

        return $code;
    }

    private function getLastCodeComande()
    {
        $code = 'CO'.date('ym').'-';
        $comande = DolibarrCommandeModel::where('ref','like',$code.'%')->orderBy('date_creation', 'desc')->first();

        if ($comande) {
            $number = ((int)str_replace($code,'',$comande->ref))+1;
            $code = $code.str_pad($number, 4, '0', STR_PAD_LEFT);

        } else {
            $code = $code.'0001';
        }
        return $code;
    }

    private function getLastCodeFacture()
    {
        $code = 'FA'.date('ym').'-';
        $facture = DolibarrFactureModel::where('facnumber','like',$code.'%')->orderBy('tms', 'desc')->first();

        if ($facture) {
            $number = ((int)str_replace($code,'',$facture->facnumber))+1;
            $code = $code.str_pad($number, 4, '0', STR_PAD_LEFT);

        } else {
            $code = $code.'0001';
        }

        return $code;
    }
    /**
     * @param $prestashopCustomer
     * @param $prestashopAddress
     *
     * @return DolibarrSocPeopleModel
     */
    public function createDolibarrSocPeople($dolibarrSociete, $prestashopCustomer, $prestashopAddress)
    {
        if ($prestashopCustomer->birthday == '0000-00-00') $prestashopCustomer->birthday = date('Y-m-d');
        $dolibarrSocPeople = new DolibarrSocPeopleModel();
        $dolibarrSocPeople->fk_soc = $dolibarrSociete->rowid;
        $dolibarrSocPeople->datec = date('Y-m-d H:i:s');
        $dolibarrSocPeople->tms = date('Y-m-d H:i:s');
        $dolibarrSocPeople->lastname = $prestashopCustomer->lastname;
        $dolibarrSocPeople->firstname = $prestashopCustomer->firstname;
        $dolibarrSocPeople->address = $prestashopAddress->address1 . ' ' . $prestashopAddress->address2;
        $dolibarrSocPeople->zip = $prestashopAddress->postcode;
        $dolibarrSocPeople->town = $prestashopAddress->city;
        $dolibarrSocPeople->fk_pays = 4;
        $dolibarrSocPeople->birthday = $prestashopCustomer->birthday;
        $dolibarrSocPeople->phone = $prestashopAddress->phone;
        $dolibarrSocPeople->email = $prestashopCustomer->email;
        $dolibarrSocPeople->fk_user_creat = 1;
        $dolibarrSocPeople->fk_user_modif = 1;
        $dolibarrSocPeople->save();

        return $dolibarrSocPeople;
    }

    /**
     * @param $prestashopCustomer
     * @param $prestashopAddress
     *
     * @return DolibarrSocieteModel
     */
    public function createDolibarrSociete($prestashopCustomer, $prestashopAddress)
    {
        $dolibarrSociete = new DolibarrSocieteModel();
        $dolibarrSociete->nom = $prestashopCustomer->lastname . ' ' . $prestashopCustomer->firstname;
        $dolibarrSociete->name_alias = '';
        $dolibarrSociete->code_client = $this->getLastCodeClient();
        $dolibarrSociete->address = $prestashopAddress->address1 . ' ' . $prestashopAddress->address2;
        $dolibarrSociete->zip = $prestashopAddress->postcode;
        $dolibarrSociete->town = $prestashopAddress->city;
        $dolibarrSociete->email = $prestashopCustomer->email;
        $dolibarrSociete->client = 1;
        $dolibarrSociete->tms = date('Y-m-d H:i:s');
        $dolibarrSociete->datec = date('Y-m-d H:i:s');
        $dolibarrSociete->fk_user_creat = 1;
        $dolibarrSociete->fk_user_modif = 1;
        $dolibarrSociete->fk_multicurrency = 0;
        $dolibarrSociete->multicurrency_code = '';
        $dolibarrSociete->save();

        return $dolibarrSociete;
    }

    /**
     * @param $dolibarrSociete
     * @param $prestashopOrder
     *
     * @return DolibarrCommandeModel
     */
    public function createNewCommande($dolibarrSociete, $prestashopOrder)
    {
        $dolibarrCommande = new DolibarrCommandeModel();
        $dolibarrCommande->ref = $this->getLastCodeComande();
        $dolibarrCommande->fk_soc = $dolibarrSociete->rowid;
        $dolibarrCommande->date_creation = date('Y-m-d H:i:s');
        $dolibarrCommande->date_valid = date('Y-m-d H:i:s');
        $dolibarrCommande->date_cloture = date('Y-m-d H:i:s');
        $dolibarrCommande->date_commande = date('Y-m-d H:i:s');
        $dolibarrCommande->tms = date('Y-m-d H:i:s');
        $dolibarrCommande->fk_user_author = 1;
        $dolibarrCommande->fk_user_valid = 1;
        $dolibarrCommande->fk_user_cloture = 1;
        $dolibarrCommande->fk_statut = 3;
        $dolibarrCommande->facture = 1;
        $dolibarrCommande->fk_cond_reglement = 6;
        $dolibarrCommande->fk_mode_reglement = 54;
        $dolibarrCommande->date_livraison = date('Y-m-d');
        $dolibarrCommande->fk_shipping_method = 2;
        $dolibarrCommande->fk_availability = 1;
        $dolibarrCommande->fk_input_reason = 1;
        $dolibarrCommande->fk_incoterms = 0;
        $dolibarrCommande->fk_multicurrency = 0;
        $dolibarrCommande->tva = $prestashopOrder->total_paid_real - $prestashopOrder->total_paid_tax_excl;
        $dolibarrCommande->total_ht = $prestashopOrder->total_paid_tax_excl;
        $dolibarrCommande->total_ttc = $prestashopOrder->total_paid_real;
        $dolibarrCommande->multicurrency_code = 'EUR';
        $dolibarrCommande->multicurrency_tx = 1.00000000;
        $dolibarrCommande->multicurrency_total_ht = $prestashopOrder->total_paid_tax_excl;
        $dolibarrCommande->multicurrency_total_tva = $prestashopOrder->total_paid_real - $prestashopOrder->total_paid_tax_excl;
        $dolibarrCommande->multicurrency_total_ttc = $prestashopOrder->total_paid_real;
        $dolibarrCommande->save();

        return $dolibarrCommande;
    }

    /**
     * @param $lineOfOrder
     * @param $dolibarrCommande
     * @param $dolibarrProduct
     *
     * @return DolibarrCommandeDetModel
     */
    public function createDolibarrCommandeDet($lineOfOrder, $dolibarrCommande, $dolibarrProduct)
    {
        $dolibarrCommandeDet = new DolibarrCommandeDetModel();
        $dolibarrCommandeDet->fk_commande = $dolibarrCommande->rowid;
        $dolibarrCommandeDet->fk_product = $dolibarrProduct->rowid;
        $dolibarrCommandeDet->label = $dolibarrProduct->label;
        $dolibarrCommandeDet->description = $dolibarrProduct->description;
        $dolibarrCommandeDet->vat_src_code = 'IVA21';
        $dolibarrCommandeDet->tva_tx = 21.000;
        $dolibarrCommandeDet->localtax1_type = 0;
        $dolibarrCommandeDet->localtax2_type = 0;
        $dolibarrCommandeDet->qty = $lineOfOrder->product_quantity;
        $dolibarrCommandeDet->price = $lineOfOrder->unit_price_tax_excl;
        $dolibarrCommandeDet->subprice = $lineOfOrder->unit_price_tax_excl;
        $dolibarrCommandeDet->total_ht = $lineOfOrder->unit_price_tax_excl;
        $dolibarrCommandeDet->total_tva = $lineOfOrder->unit_price_tax_incl - $lineOfOrder->unit_price_tax_excl;
        $dolibarrCommandeDet->total_ttc = $lineOfOrder->unit_price_tax_incl;
        $dolibarrCommandeDet->rang = 1;
        $dolibarrCommandeDet->multicurrency_code = 'EUR';
        $dolibarrCommandeDet->multicurrency_subprice = $lineOfOrder->unit_price_tax_excl;
        $dolibarrCommandeDet->multicurrency_total_ht = $lineOfOrder->unit_price_tax_excl;
        $dolibarrCommandeDet->multicurrency_total_tva = $lineOfOrder->unit_price_tax_incl - $lineOfOrder->unit_price_tax_excl;
        $dolibarrCommandeDet->multicurrency_total_ttc = $lineOfOrder->unit_price_tax_incl;
        $dolibarrCommandeDet->remise_percent = $lineOfOrder->reduction_percent;
        $dolibarrCommandeDet->save();

        return $dolibarrCommandeDet;
    }

    /**
     * @param $dolibarrSocPeople
     * @param $prestashopOrder
     *
     * @return DolibarrFactureModel
     */
    public function createDolibarrFacture($dolibarrSociete, $prestashopOrder)
    {
        $dolibarrFacture = new DolibarrFactureModel();
        $dolibarrFacture->facnumber = $this->getLastCodeFacture();
        $dolibarrFacture->fk_soc = $dolibarrSociete->rowid;
        $dolibarrFacture->datec = date('Y-m-d H:i:s');
        $dolibarrFacture->datef = date('Y-m-d');
        $dolibarrFacture->date_valid = date('Y-m-d');
        $dolibarrFacture->tms = date('Y-m-d H:i:s');
        $dolibarrFacture->paye = 1;
        $dolibarrFacture->tva = $prestashopOrder->total_paid_real - $prestashopOrder->total_paid_tax_excl;
        $dolibarrFacture->total = $prestashopOrder->total_paid_tax_excl;
        $dolibarrFacture->total_ttc = $prestashopOrder->total_paid_real;
        $dolibarrFacture->fk_statut = 2;
        $dolibarrFacture->fk_user_author = 1;
        $dolibarrFacture->fk_user_valid = 1;
        $dolibarrFacture->fk_cond_reglement = 0;
        $dolibarrFacture->fk_mode_reglement = 6;
        $dolibarrFacture->date_lim_reglement = date('Y-m-d');
        $dolibarrFacture->situation_final = 0;
        $dolibarrFacture->fk_multicurrency = 0;
        $dolibarrFacture->multicurrency_code = 'EUR';
        $dolibarrFacture->save();

        return $dolibarrFacture;
    }

    /**
     * @param $dolibarrFacture
     * @param $dolibarrProduct
     * @param $lineOfOrder
     *
     * @return DolibarrFactureDetModel
     */
    public function createDolibarrFactureDet($dolibarrFacture, $dolibarrProduct, $lineOfOrder)
    {
        $dolibarrFactureDet = new DolibarrFactureDetModel();
        $dolibarrFactureDet->fk_facture = $dolibarrFacture->rowid;
        $dolibarrFactureDet->fk_product = $dolibarrProduct->rowid;
        $dolibarrFactureDet->label = $dolibarrProduct->label;
        $dolibarrFactureDet->description = $dolibarrProduct->description;
        $dolibarrFactureDet->vat_src_code = 'IVA21';
        $dolibarrFactureDet->tva_tx = 21.000;
        $dolibarrFactureDet->localtax1_type = 0;
        $dolibarrFactureDet->localtax2_type = 0;
        $dolibarrFactureDet->qty = $lineOfOrder->product_quantity;
        $dolibarrFactureDet->subprice = $lineOfOrder->unit_price_tax_excl;
        $dolibarrFactureDet->total_ht = $lineOfOrder->unit_price_tax_excl;
        $dolibarrFactureDet->total_tva = $lineOfOrder->unit_price_tax_incl - $lineOfOrder->unit_price_tax_excl;
        $dolibarrFactureDet->total_ttc = $lineOfOrder->unit_price_tax_incl;
        $dolibarrFactureDet->buy_price_ht = $dolibarrProduct->cost_price;
        $dolibarrFactureDet->situation_percent = 100;
        $dolibarrFactureDet->fk_user_author = 1;
        $dolibarrFactureDet->fk_user_modif = 1;
        $dolibarrFactureDet->fk_multicurrency = 0;
        $dolibarrFactureDet->remise_percent = $lineOfOrder->reduction_percent;
        $dolibarrFactureDet->save();

        return $dolibarrFactureDet;
    }

    /**
     * @param $dolibarrCommande
     *
     * @return DolibarrBankModel
     */
    public function createDolibarrBank($dolibarrCommande)
    {
        $dolibarrBank = new DolibarrBankModel();
        $dolibarrBank->datec = date('Y-m-d H:i:s');
        $dolibarrBank->datev = date('Y-m-d');
        $dolibarrBank->dateo = date('Y-m-d');
        $dolibarrBank->tms = date('Y-m-d H:i:s');
        $dolibarrBank->amount = $dolibarrCommande->total_ttc;
        $dolibarrBank->label = '(CustomerInvoicePayment)';
        $dolibarrBank->fk_account = 2;
        $dolibarrBank->fk_user_author = 1;
        $dolibarrBank->fk_type = 'CB';
        $dolibarrBank->save();

        return $dolibarrBank;
    }
}