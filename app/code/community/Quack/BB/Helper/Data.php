<?php
/**
 * Este arquivo é parte do programa Quack BB
 *
 * Quack BB é um software livre; você pode redistribuí-lo e/ou
 * modificá-lo dentro dos termos da Licença Pública Geral GNU como
 * publicada pela Fundação do Software Livre (FSF); na versão 3 da
 * Licença, ou (na sua opinião) qualquer versão.
 *
 * Este programa é distribuído na esperança de que possa ser  útil,
 * mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO
 * a qualquer MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a
 * Licença Pública Geral GNU para maiores detalhes.
 *
 * Você deve ter recebido uma cópia da Licença Pública Geral GNU junto
 * com este programa, Se não, veja <http://www.gnu.org/licenses/>.
 *
 * @category   Quack
 * @package    Quack_BB
 * @author     Rafael Patro <rafaelpatro@gmail.com>
 * @copyright  Copyright (c) 2015 Rafael Patro (rafaelpatro@gmail.com)
 * @license    http://www.gnu.org/licenses/gpl.txt
 * @link       https://github.com/rafaelpatro/Quack_BB
 */

class Quack_BB_Helper_Data extends Mage_Core_Helper_Abstract
{    
    public function strtoascii($str) {
        setlocale(LC_ALL, 'pt_BR.utf8');
        return iconv('UTF-8', 'ASCII//TRANSLIT', $str);
    }
    
    public function getExpirationDate($date, $deadline) {
        $time = new DateTime($date);
        $time->add(new DateInterval("P{$deadline}D"));
        return $time->format('dmY');
    }
    
    public function getFormattedCity($addr) {
        $city = strtoupper($addr->getCity());
        $city = $this->strtoascii($city);
        $city = preg_replace('/[^A-Z\'\-\s]/', '', $city);
        $city = preg_replace('/[\s\'\-]{2,}/', ' ', $city);
        $city = preg_replace('/[\n\r\t]/', ' ', $city);
        $city = trim($city);
        $city = substr($city, 0, 18);
        return $city;
    }
    
    public function getFormattedPostcode($addr) {
        $postcode = $addr->getPostcode();
        $postcode = preg_replace('/[^\d]/', '', $postcode);
        $postcode = substr($postcode, 0, 8);
        return $postcode;
    }
    
    public function getFormattedAddress($addr) {
        $streetFull = strtoupper($addr->getStreetFull());
        $streetFull = $this->strtoascii($streetFull);
        $streetFull = preg_replace('/[^0-9A-Z\'\-\s]/', '', $streetFull);
        $streetFull = preg_replace('/[\s\'\-]{2,}/', ' ', $streetFull);
        $streetFull = preg_replace('/[\n\r\t]/', ' ', $streetFull);
        $streetFull = substr($streetFull, 0, 60);
        return $streetFull;
    }
    
    /**
     * Retrieve formatted Name by order address
     * 
     * @param Mage_Sales_Model_Order_Address $addr
     * @return string
     */
    public function getFormattedCustomerName($addr) {
        $name = "{$addr->getFirstname()} {$addr->getLastname()}";
        $name = $this->getFormattedName($name);
        return $name;
    }

    /**
     * Retrieve formatted Company by order address
     *
     * @param Mage_Sales_Model_Order_Address $addr
     * @return string
     */
    public function getFormattedCompanyName($addr) {
        $name = $addr->getFirstname();
        $name = $this->getFormattedName($name);
        return $name;
    }
    
    public function getFormattedName($name) {
        $name = strtoupper($name);
        $name = $this->strtoascii($name);
        $name = preg_replace('/[^A-Z\'\-\s]/', '', $name);
        $name = preg_replace('/[\s\'\-]{2,}/', ' ', $name);
        $name = substr($name, 0, 60);
        return $name;
    }
    
    public function getFormattedAmount($amount) {
        $amount = number_format($amount, 2, '', '');
        return $amount;
    }
    
    public function isBankSlipAvailable($type) {
        return in_array($type, array(
            Quack_BB_Model_Source_TpPagamento::NOT_SET,
            Quack_BB_Model_Source_TpPagamento::BANK_SLIP,
            Quack_BB_Model_Source_TpPagamento::BANK_SLIP_DUPLICATE
        ));
    }
}
?>
