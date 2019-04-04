<?php
/* Copyright (C) ---Put here your own copyright and developer email---
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * \file    core/triggers/interface_99_modprestabarr_prestabarrTriggers.class.php
 * \ingroup prestabarr
 * \brief   Example trigger.
 *
 * Put detailed description here.
 *
 * \remarks You can create other triggers by copying this one.
 * - File name should be either:
 *      - interface_99_modprestabarr_MyTrigger.class.php
 *      - interface_99_all_MyTrigger.class.php
 * - The file must stay in core/triggers
 * - The class name must be InterfaceMytrigger
 * - The constructor method must be named InterfaceMytrigger
 * - The name property name must be MyTrigger
 */

require_once DOL_DOCUMENT_ROOT.'/core/triggers/dolibarrtriggers.class.php';


/**
 *  Class of triggers for prestabarr module
 */
class InterfacePrestabarrTriggers extends DolibarrTriggers
{
	/**
	 * @var DoliDB Database handler
	 */
	protected $db;
    private $url;
    private $token;
	/**
	 * Constructor
	 *
	 * @param DoliDB $db Database handler
	 */
	public function __construct($db)
	{
		$this->db = $db;
		$this->name = preg_replace('/^Interface/i', '', get_class($this));
		$this->family = "prestabarr";
		$this->description = "prestabarr triggers.";
		$this->version = '1.0';
		$this->picto = 'prestabarr@prestabarr';

        $this->url = $this->getUrl();
        $this->token = $this->getToken();

        if (!$this->url || !$this->token) {
            dol_syslog("PRESTABARR ERROR: URL OR TOKEN NOT SET.");
            die();
        }
	}

	/**
	 * Trigger name
	 *
	 * @return string Name of trigger file
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Trigger description
	 *
	 * @return string Description of trigger file
	 */
	public function getDesc()
	{
		return $this->description;
	}


	/**
	 * Function called when a Dolibarrr business event is done.
	 * All functions "runTrigger" are triggered if file
	 * is inside directory core/triggers
	 *
	 * @param string 		$action 	Event action code
	 * @param CommonObject 	$object 	Object
	 * @param User 			$user 		Object user
	 * @param Translate 	$langs 		Object langs
	 * @param Conf 			$conf 		Object conf
	 * @return int              		<0 if KO, 0 if no triggered ran, >0 if OK
	 */
	public function runTrigger($action, $object, User $user, Translate $langs, Conf $conf)
	{

	    if ($action == 'STOCK_MOVEMENT') {
	        $uri = '/dolibarrStock';
            $sql = 'SELECT p.*, ps.reel, ps.fk_entrepot
                    FROM '.MAIN_DB_PREFIX.'product p
                    LEFT JOIN '.MAIN_DB_PREFIX.'product_stock as ps ON (ps.fk_product = p.rowid and ps.fk_entrepot = '.$object->entrepot_id.')
                    WHERE p.entity IN (0, '.$conf->entity.') AND p.rowid='.$object->product_id.' ORDER BY p.rowid ';
            $res = $this->db->query($sql);
            $produits = $this->db->fetch_array($res);

            $this->connectorLaravel($uri, $produits['ref'], $produits['reel']);

            dol_syslog("Trigger '".$this->name."' for action '$action' launched by ".__FILE__.". id=".$object->ref);

        } else if ($action == 'PRODUCT_MODIFY' || $action == 'PRODUCT_CREATE') {
            $uri = '/dolibarrProduct';
            $this->connectorLaravel($uri, $object->ref, '');

            dol_syslog("Trigger '".$this->name."' for action '$action' launched by ".__FILE__.". id=".$object->ref);

        } else if ($action == 'PRODUCT_PRICE_MODIFY') {
            $uri = '/dolibarrPrice';
            $this->connectorLaravel($uri, $object->ref, $object->price);

            dol_syslog("Trigger '".$this->name."' for action '$action' launched by ".__FILE__.". id=".$object->ref);

        }
        else if ($action == 'BILL_PAYED') {

            if (!empty($object->note)) {
                $type = 'Efectivo';
            } else {
                $type = 'Tarjeta';
            }
            $uri = '/slackBillingNotification';

            $this->connectorLaravel($uri,$object->newref, $type);

            dol_syslog("Trigger '".$this->name."' for action '$action' launched by ".__FILE__.". id=".$object->id);
        }
        
		return 0;
	}

	private function connectorLaravel($uri, $ref, $params)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url.$uri,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "ref=$ref&params=$params",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $this->token",
                "cache-control: no-cache"
            ),
        ));
        curl_exec($curl);
        curl_close($curl);
    }

    public function getUrl()
    {
        $sql = 'SELECT * FROM ' . MAIN_DB_PREFIX . 'const WHERE name = "PRESTABARR_URL"';
        $res = $this->db->query($sql);
        $array = $this->db->fetch_array($res);
        return $array['value'];
    }

    public function getToken()
    {
        $sql = 'SELECT * FROM ' . MAIN_DB_PREFIX . 'const WHERE name = "PRESTABARR_KEY"';
        $res = $this->db->query($sql);
        $array = $this->db->fetch_array($res);
        return $array['value'];
    }
}
