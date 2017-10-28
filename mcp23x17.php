<?php
/*
 * Library for MCP23x17 i2c communication
 * 
 * @copyright (c) 2017, Shane Chrisp
 * @license GPLv3
 * 
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */

/**
 *  include parent class
 */
require_once( 'i2c_bus.php' );

class mcp23x17 extends i2c_bus {
    
    /** 
     * Constants for MCP23017 IOCON.BANK = 0 Port A
     */
    
    /**
     * @var string IODIRA GPIO A Direction address
     */
    const IODIRA    = "0x00";
    
    /**
     * @var string IPOLA GPIO A Polarity address
     */
    const IPOLA     = "0x02";
    
    /**
     * @var string GPINTENA GPIO A Interrupt Enable address
     */
    const GPINTENA  = "0x04";
    
    /**
     * @var string DEFVALA GPIO A Default Value address
     */
    const DEFVALA   = "0x06";
    
    /**
     * @var string INTCONA GPIO A Interrupt-On-Change address
     */
    const INTCONA   = "0x08";
    
    /**
     * @var string IOCONA GPIO A I/O Expander address
     */
    const IOCONA    = "0x0A";
    
    /**
     * @var string GPPUA GPIO A Pull-Ups address
     */
    const GPPUA     = "0x0C";
    
    /**
     * @var string INTFA GPIO A Interrupt Flag address
     */
    const INTFA     = "0x0E";
    
    /**
     * @var string INTCAPA GPIO A Interrupt Captured Value address
     */
    const INTCAPA   = "0x10";
    
    /**
     * @var string GPIOA GPIO A port register address
     */
    const GPIOA     = "0x12";
    
    /**
     * @var string OLATA GPIO A Output Latch register address
     */
    const OLATA     = "0x14";
    
    /** 
     * Constants for MCP23017 IOCON.BANK = 0 Port B
     */
    
    /**
     * @var string IODIRB GPIO B Direction address
     */
    const IODIRB    = "0x01";
    
    /**
     * @var string IPOLB GPIO B Polarity address
     */
    const IPOLB     = "0x03";
    
    /**
     * @var string GPINTENB GPIO B Interrupt Enable address
     */
    const GPINTENB  = "0x05";
    
    /**
     * @var string DEFVALB GPIO B Default Value address
     */
    const DEFVALB   = "0x07";
    
    /**
     * @var string INTCONB GPIO B Interrupt-On-Change address
     */
    const INTCONB   = "0x09";
    
    /**
     * @var string IOCONB GPIO B I/O Expander address
     */
    const IOCONB    = "0x0D";
    
    /**
     * @var string GPPUB GPIO B Pull-Ups address
     */
    const GPPUB     = "0x16";
    
    /**
     * @var string INTFB GPIO B Interrupt Flag address
     */
    const INTFB     = "0x0F";
    
    /**
     * @var string INTCAPB GPIO B Interrupt Captured Value address
     */
    const INTCAPB   = "0x11";
    
    /**
     * @var string GPIOB GPIO B port register address
     */
    const GPIOB     = "0x13";
    
    /**
     * @var string OLATB GPIO B Output Latch register address
     */
    const OLATB     = "0x15";
    
    /**
     * Other constants
     */
    
    /**
     * @var string GPIO Output
     */
    const OUTPUT    = "0";
    
    /**
     * @var string Input
     */
    const INPUT     = "1";
        
    /**
     * @var string i2c_address Hex address of i2c device
     * @access private
     */
	private $i2c_address;

    /**
     *
     * @var string Hex address of register as a string
     */
    private $registeraddress;
    

    function __construct( ) {
        parent::__construct( $this->i2c_address );
    }
    
    // ------------ SETTERS ------------
    
    /**
     * Sets the address of the i2c device
     * 
     * @var string $i2c_address Hex address of i2c device as a string
     * @access public
     * @return null
     */
    public function setI2CAddress( $i2c_address ) {
        $this->i2c_address = $i2c_address;
    }

    /**
     * Configures the direction of the GPIO ports on the i2c device
     * 
     * @var string $registeraddress Hex address of i2c device as a string
     * @var string $iodirection Hex value to set ports as input or output
     * @access public
     * @return null
     */
    public function setIODirection( $registeraddress, $iodirection ) {
        parent::write_register( $this->i2c_address, $registeraddress, $iodirection );
	}
    
    /**
     * Sets the state of the individual GPIO A ports
     * 
     * @var string $value Binary state of the port state
     * @access public
     * @return null
     */
    public function setPortAState( $value ) {
        $a = str_split($value, 1);
        
        $this->porta0 = $a[0];
        $this->porta1 = $a[1];
        $this->porta2 = $a[2];
        $this->porta3 = $a[3];
        $this->porta4 = $a[4];
        $this->porta5 = $a[5];
        $this->porta6 = $a[6];
        $this->porta7 = $a[7];
    }
    
    /**
     * Sets the state of the individual GPIO B ports
     * 
     * @var string $value Binary state of the port state
     * @access public
     * @return null
     */
    public function setPortBState( $value ) {
        $a = str_split($value, 1);
        
        $this->portb0 = $a[0];
        $this->portb1 = $a[1];
        $this->portb2 = $a[2];
        $this->portb3 = $a[3];
        $this->portb4 = $a[4];
        $this->portb5 = $a[5];
        $this->portb6 = $a[6];
        $this->portb7 = $a[7];
    }
    
    // ------------ GETTERS ------------

    /**
     * Port A 
     */
    
    /**
     * Returns the direction of port A.
     * 
     * 1 = Pin is configured as an input.
     * 0 = Pin is configured as an output.
     * 
     * @return string
     */
    public function getIODIRA( ) {
        return self::IODIRA;
    }
    
    /**
     * Returns the polarity of port A
     * 
     * 1 = GPIO register bit reflects the opposite logic state of the input pin.
     * 0 = GPIO register bit reflects the same logic state of the input pin.
     * 
     * @return string
     */
    public function getIPOLA( ) {
        return self::IPOLA;
    }
    
    /**
     * Returns the state of Interrupt on Change of port A
     * 
     * 1 = Enables GPIO input pin for interrupt-on-change event.
     * 0 = Disables GPIO input pin for interrupt-on-change event.
     * 
     * @return string
     * @access public
     */
    public function getGPINTENA( ) {
        return self::GPINTENA;
    }
    
    /**
     * Returns the state of Default Value Register of port A
     * 
     * @return string
     * @access public
     */
    public function getDEFVALA( ) {
        return self::DEFVALA;
    }
   
    /**
     * Returns the state of the Interrupt Control Register of port A
     * 
     * @return string
     * @access public
     */
    public function getINTCONA( ) {
        return self::INTCONA;
    }
    
    /**
     * Returns the state of the I/O Expander Register of port A
     * 
     * @return string
     * @access public
     */
    public function getIOCONA( ) {
        return self::IOCONA;
    }
    
    /**
     * Returns the state of Pull-Up Resister Register of port A
     * 
     * @return string
     * @access public
     */
    public function getGPPUA( ) {
        return self::GPPUA;
    }
    
    /**
     * Returns the state of the Interrupt Flag Register of port A
     * 
     * @return string
     * @access public
     */
    public function getINTFA( ) {
        return self::INTFA;
    }
    
    /**
     * Returns the state of the Interrupt Captured Value Register of port A
     * 
     * @return string
     * @access public
     */
    public function getINTCAPA( ) {
        return self::INTCAPA;
    }
    
    /**
     * Returns the state of the Port Register of port A
     * 
     * @return string
     * @access public
     */
    public function getGPIOA( ) {
        return self::GPIOA;
    }
    
    /**
     * Returns the state of the Output Latch Register of port A
     * 
     * @return string
     * @access public
     */
    public function getOLATA( ) {
        return self::OLATA;
    }
    
    /**
     *  Port B 
     */
    
    /**
     * Returns the state of Interrupt on Change of port B
     * 
     * 1 = Enables GPIO input pin for interrupt-on-change event.
     * 0 = Disables GPIO input pin for interrupt-on-change event.
     * 
     * @return string
     * @access public
     */
    public function getIODIRB( ) {
        return self::IODIRB;
    }
    
    /**
     * Returns the state of Default Value Register of port B
     * 
     * @return string
     * @access public
     */
    public function getIPOLB( ) {
        return self::IPOLB;
    }
    
    /**
     * Returns the state of the Interrupt Control Register of port B
     * 
     * @return string
     * @access public
     */
    public function getGPINTENB( ) {
        return self::GPINTENB;
    }
    
    /**
     * Returns the state of Default Value Register of port B
     * 
     * @return string
     * @access public
     */
    public function getDEFVALB( ) {
        return self::DEFVALB;
    }
    
    /**
     * Returns the state of the I/O Expander Register of port B
     * 
     * @return string
     * @access public
     */
    public function getINTCONB( ) {
        return self::INTCONB;
    }
    
    /**
     * Returns the state of the I/O Expander Register of port B
     * 
     * @return string
     * @access public
     */
    public function getIOCONB( ) {
        return self::IOCONB;
    }
    
    /**
     * Returns the state of Pull-Up Resister Register of port B
     * 
     * @return string
     * @access public
     */
    public function getGPPUB( ) {
        return self::GPPUB;
    }
    
    /**
     * Returns the state of the Interrupt Flag Register of port B
     * 
     * @return string
     * @access public
     */
    public function getINTFB( ) {
        return self::INTFB;
    }
    
    /**
     * Returns the state of the Interrupt Captured Value Register of port B
     * 
     * @return string
     * @access public
     */
    public function getINTCAPB( ) {
        return self::INTCAPB;
    }
    
    /**
     * Returns the state of the Port Register of port B
     * 
     * @return string
     * @access public
     */
    public function getGPIOB( ) {
        return self::GPIOB;
    }
    
    /**
     * Returns the state of the Output Latch Register of port A
     * 
     * @return string
     * @access public
     */
    public function getOLATB( ) {
        return self::OLATB;
    }
    
    /**
     * Returns the i2c address of the device set in the instantiated class
     * 
     * @return string
     */
    public function getI2CAddress( ) {
        return $this->i2c_address;
    }

    public function getRegisterAddress( ) {
        return $this->registeraddress;
    }

    /**
     * Get readings from i2c bus
     * 
     * @param string $registeraddress Hex address as string of register to read
     * @return string
     * @access public
     */
	public function getReadings( $registeraddress ) {
		return parent::read_register( $this->i2c_address, $this->registeraddress );
	}
    
 /**
  * Finds i2c devices
  *
  * @param string $adresseses is the output of the read_detect function which 
  *     should be called prior to calling this function
  *
  * @return array an array containing the found i2c devices on the bus
  */
    public function geti2cdevices( $adresseses ) {
        $result = explode( "\n", $adresseses );
        foreach ( $result as $key => $val ) {
            $line = explode(" ", $val);
                foreach ( $line as $item => $value ) {
                    if ((strlen($value) == 2) && ($value != "--")) { 
                        $arr[] = "0x".$value;
                    }
                }
        }
        return $arr;
    }
    
    /**
     * Returns the state of the GPIO Port A0
     * 
     * @return string
     * @access public
     */
    public function getPorta0() {
        return $this->porta0;
    }
    
    /**
     * Returns the state of the GPIO Port A1
     * 
     * @return string
     * @access public
     */
    public function getPorta1() {
        return $this->porta1;
    }
    
    /**
     * Returns the state of the GPIO Port A2
     * 
     * @return string
     * @access public
     */
    public function getPorta2() {
        return $this->porta2;
    }
    
    /**
     * Returns the state of the GPIO Port A3
     * 
     * @return string
     * @access public
     */
    public function getPorta3() {
        return $this->porta3;
    }
    
    /**
     * Returns the state of the GPIO Port A4
     * 
     * @return string
     * @access public
     */
    public function getPorta4() {
        return $this->porta4;
    }
    
    /**
     * Returns the state of the GPIO Port A5
     * 
     * @return string
     * @access public
     */
    public function getPorta5() {
        return $this->porta5;
    }
    
    /**
     * Returns the state of the GPIO Port A6
     * 
     * @return string
     * @access public
     */
    public function getPorta6() {
        return $this->porta6;
    }
    
    /**
     * Returns the state of the GPIO Port A7
     * 
     * @return string
     * @access public
     */
    public function getPorta7() {
        return $this->porta7;
    }
    
    /**
     * Returns the state of the GPIO Port B0
     * 
     * @return string
     * @access public
     */
    public function getPortb0() {
        return $this->portb0;
    }
    
    /**
     * Returns the state of the GPIO Port B1
     * 
     * @return string
     * @access public
     */
    public function getPortb1() {
        return $this->portb1;
    }
    
    /**
     * Returns the state of the GPIO Port B2
     * 
     * @return string
     * @access public
     */
    public function getPortb2() {
        return $this->portb2;
    }
    
    /**
     * Returns the state of the GPIO Port B3
     * 
     * @return string
     * @access public
     */
    public function getPortb3() {
        return $this->portb3;
    }
    
    /**
     * Returns the state of the GPIO Port B4
     * 
     * @return string
     * @access public
     */
    public function getPortb4() {
        return $this->portb4;
    }
    
    /**
     * Returns the state of the GPIO Port B5
     * 
     * @return string
     * @access public
     */
    public function getPortb5() {
        return $this->portb5;
    }
    
    /**
     * Returns the state of the GPIO Port B6
     * 
     * @return string
     * @access public
     */
    public function getPortb6() {
        return $this->portb6;
    }
    
    /**
     * Returns the state of the GPIO Port B7
     * 
     * @return string
     * @access public
     */
    public function getPortb7() {
        return $this->portb7;
    }
    
    /**
     * Returns 8 bit number from the supplied Hex value. The resulting number
     *  is padded with zeros to always be 8 bits.
     * 
     * @var $hexval string Hex value to convert to binary
     * @return string 8 bit binary number
     * @access public
     */
    public function converthex2bin ( $hexval ) {
        $binval = base_convert( $hexval , 16, 2);
        if ( strlen( $binval ) != 8 ) {
            if ($binval == '0') {
                return '00000000';
            } else {
                $length = strlen( $binval );
                switch ($length) {
                    case 7:
                        $binval = '0'.$binval;
                        break;
                    case 6:
                        $binval = '00'.$binval;
                        break;
                    case 5:
                        $binval = '000'.$binval;
                        break;
                    case 4:
                        $binval = '0000'.$binval;
                        break;
                    case 3:
                        $binval = '00000'.$binval;
                        break;
                    case 2:
                        $binval = '000000'.$binval;
                        break;
                    case 1:
                        $binval = '0000000'.$binval;
                }
                return $binval;
            }            
        } else {
            return $binval;
        }
    }

}