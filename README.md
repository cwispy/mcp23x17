    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.


# mcp23x17
Php Class for controlling the MCP23x17 IC with the Raspberry Pi from php

If you do not have the i2c-tools installed on the Pi you can install them 
with the below command on raspbian

sudo apt-get intstall i2c-tools -y

You also need to allow the web server permissions to run the i2cdetect, i2cset and i2cget tools.
Add the webserver to the i2c group. On raspbian this can be done with the commmand

sudo adduser www-data irc

Example usage:

Include the class file in your project. Edit the location as necessary
  
  require_once('classes/mcp23x17.php');

Instantiate the class 

  $mcp = new mcp23x17();

Finds devices connected to the Raspberry Pi and returns them as an array.
an example of the data returned: { "0x20", "0x24" }

  $res = $mcp->geti2cdevices( $m->read_detect() );

Set the address of the i2c device

  $mcp->setI2CAddress("0x21");

Set the direction of the GPIO bank A ports to all Outputs
binary would be 00000000
the getIODIRA function is a constant defined in the class to make it
easier to address the correct register

  $mcp->setIODirection( $t->getIODIRA(), '0x00' );

Set the direction of the GPIO bank B ports. In this example we set ports b0-b3 and b7 as inputs
while ports b4-b6 are outputs binary representation of that would be 10001111
converting to hex gives us 0x8F

  $mcp->setIODirection( $t->getIODIRB(), '0x8F' );


To get the readings from the GPIO ports

  $mcp->getReadings( $t->getGPIOA() );

Or to read for the Latches instead we would use

  $mcp->getReadings( $t->getOLATA() );

To get the status of the individual port a0 we can use the getPorta0 function.
This will return
0 for low or off
1 for high or on

  $result = $mcp->getPorta0();
