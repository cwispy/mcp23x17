<?php
/*
 * Class to deal with i2c communications on the raspberry pi
 * 
 * This class makes use of i2c-tools ( sudo apt-get install i2c-tools -y )
 * 
 * To allow the apache web server permission to run the i2c commands 
 * run the command ( sudo adduser www-data i2c )
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

class i2c_bus {

    /** 
     * The i2c block 
     * 0 on first generation raspberry Pi
     * 1 on newer generation raspberry Pi
     *
     * @var int $block number of the i2c device block
     */
	private $block = 1;
    
    /**
     * The i2c bus address of the unit being communicated with 
     * set when class is instantiated
     * 
     * @var string $i2c_address Hex address of i2c device as a string
     * @access private
     */
	private $i2c_address;

	function __construct( $i2c_address ) {

		$this->i2c_address = $i2c_address;

	}
    
    /** 
     * Detect devices connected on the i2c bus
     * 
     * @return string
     * @access public
     */
	public function read_detect( ) {
		return shell_exec( 'i2cdetect -y ' . $this->block );
	}
    
    /** 
     * Read from the i2c bus register
     * 
     * @param string $i2c_address Hex address of i2c device as a string
     * @param string $register Hex address as a string of register to read
     * @return string 
     * @access public
     */
	public function read_register( $i2c_address, $register ) {
        
		return trim( shell_exec( 'i2cget -y ' . $this->block . ' ' 
                . $i2c_address . ' ' . $register ) );
	}

    /**
     * Write to the i2c bus
     * 
     * @param string $i2c_address Hex address of i2c device as a string
     * @param string $register Hex address as a string of register to read
     * @param string $value Hex value as a string of values to write
     * @access public
     */
	public function write_register( $i2c_address, $register, $value ) {
        
		shell_exec( 'i2cset -y ' . $this->block . ' ' . $i2c_address . ' ' 
                . $register . ' ' . $value );
	}

}