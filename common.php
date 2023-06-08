<?php
/**
 *  Commonly used functions for PHP development aggregated within this class.
 *  Copyright 2009-2023 Rich Morgan (rich@richmorgan.me)
 *
 *  common.php
 * 
 *  Changes: 2/1/2013, 
 *    Added encryption/decryption routines. -RLM
 *    Improved calendar code. -RLM
 *    Completed parsedate() function. -RLM
 *
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License along
 *  with this program; if not, write to the Free Software Foundation, Inc.,
 *  51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

class common
{
  /**
  * Yet another generic function to help ensure safe
  * data is used in database functions.
  *
  * @param string $data
  * @return string $data
  * @throws \Exception $e
  */
  public static function db_data_escape($data)
  {
    try {
      if (!empty($data) && is_string($data))
        return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $data);

      return $data;
    } catch (\Exception $e) {
      return 'Error: ' . $e->getMessage();
    }
  }

  /**
  * Yet another generic function to help ensure safe
  * data is used in database functions.
  *
  * @param string $data
  * @return string $data
  * @throws \Exception $e
  */
  public static function scrub($data)
  {
    try {
      return trim(strip_tags(htmlentities($data)));
    } catch (\Exception $e) {
      return 'Error: ' . $e->getMessage();
    }
  }

  /**
  * Function for converting programming code within <code> ... </code>
  * tags into safe HTML for display in blogs or other websites.
  *
  * @param string $data
  * @return string $data
  * @throws \Exception $e
  */
  public static function blogscrub($data)
  {
    try {
      $codestart = strpos($data,'<code>') + 6;
      $codeend = strpos($data,'</code>');

      if ($codestart >= 0 && $codeend > $codestart)
        return substr($data,0,$codestart) . htmlentities(substr($data,$codestart,($codeend-strlen($data)))) . substr($data,$codeend);
      else
        return $data;
    } catch (Exception $e) {
      return 'Error: ' . $e->getMessage();
    }
  }

  /**
  * Creates a monthly calendar based on the timezone specified. Calendar data returned is
  * in HTML table form.
  *
  * @param string $debug
  * @param string $timezone
  * @return string $calendar_html
  * @throws \Exception $e
  */
  public static function calendar($debug='false',$timezone='UTC')
  {
    try {
      date_default_timezone_set($timezone);
      $now = getdate(time());
      $time = mktime(0,0,0, $now['mon'], 1, $now['year']);
      $date = getdate($time);
      $dayTotal = cal_days_in_month(0, $date['mon'], $date['year']);
      $calendar_html = '';

      if ($debug=='true') {
        /* Display the variables for debugging. */
        print '<pre>';
        print '$now = ';
        print_r($now);
        print "\n";
        print '$time = ';
        print_r($time);
        print "\n";
        print '$date = ';
        print_r($date);
        print "\n";
        print '$dayTotal = ';
        print_r($dayTotal);
        print '</pre><br /><br />';
      }

      /* Print the calendar header with the month name. */
      $calendar_html = '<table border="0" cellspacing="5" cellpadding="3" width="805" style="font-family: Arial; border:1px #000 solid;"><tr><td colspan="7" style="background: #eee; border:1px #000 solid; font-size:1.25em;" height="50" ><center><strong>' . $date['month'] . '</strong></center></td></tr>' .
                       '<tr><td valign="top" width="105" height="30" style="border:1px #000 solid;"><strong>Sunday</strong></td>' .
                       '<td valign="top" width="105" height="30" style="border:1px #000 solid;"><strong>Monday</strong></td>' .
                       '<td valign="top" width="105" height="30" style="border:1px #000 solid;"><strong>Tuesday</strong></td>' .
                       '<td valign="top" width="105" height="30" style="border:1px #000 solid;"><strong>Wednesday</strong></td>' .
                       '<td valign="top" width="105" height="30" style="border:1px #000 solid;"><strong>Thursday</strong></td>' .
                       '<td valign="top" width="105" height="30" style="border:1px #000 solid;"><strong>Friday</strong></td>' .
                       '<td valign="top" width="105" height="30" style="border:1px #000 solid;"><strong>Saturday</strong></td></tr>';

      /* Weeks */
      for ($i = 0; $i < 6; $i++) {
        $calendar_html = $calendar_html .  '<tr>' . "\n";

        /* Days */
        for ($j = 1; $j <= 7; $j++) {
          $dayNum = $j + $i*7 - $date['wday'];

          /* Print a table cell with the day number in it.  If it is today, highlight it. */
          $calendar_html = $calendar_html .  '<td valign="top" width="105" height="105"';
          if ($dayNum > 0 && $dayNum <= $dayTotal) {
            if ($dayNum == $now['mday'])
              $calendar_html = $calendar_html . ' style="background: #eee; font-weight:bold; border:1px #000 solid;">';
            else
              $calendar_html = $calendar_html . ' style="border:1px #000 solid;">';

            $calendar_html = $calendar_html .  $dayNum;
          } else {
            /* Print a blank cell if no date falls on that day, but the row is unfinished. */
            $calendar_html = $calendar_html . '>&nbsp;' . "\n";
          }

          $calendar_html = $calendar_html .  '</td>' . "\n";
        }

        $calendar_html = $calendar_html .  '</tr>' . "\n";

        if ($dayNum >= $dayTotal && $i != 6)
          break;
      }

      $calendar_html = $calendar_html .  '</table>' . "\n";

      return $calendar_html;
    } catch (\Exception $e) {
      return 'Error: ' . $e->getMessage();
    }
  }

  /**
  * Creates an array out of a string date format.
  *
  * @param string $date
  * @return array $date
  * @throws \Exception $e
  */
  public static function parsedate($date)
  {
    try {
      /* Take a date in any format and return an array. */
      if (!empty($text) && is_string($text)) {
        $tempdata = str_replace("/","~",$date);
        $tempdata = str_replace("-","~",$date);
        $temparray = explode("~",$tempdata);  
        return $temparray;
      } else {
        return $date;
      }
    } catch (\Exception $e) {
      return 'Error: ' . $e->getMessage();
    }
  }

  /**
  * Encrypts $text based on your $key and $iv.  The returned text is
  * base-64 encoded to make it easier to work with in various scenarios.
  *
  * @param string $text
  * @param string $key
  * @param string $iv
  * @param int $bit_check
  * @param string $cypher_type
  * @return string $text
  * @throws \Exception $e
  */
  public static function encrypt($text,$key='',$iv='',$bit_check=8,$cypher_type=MCRYPT_TRIPLEDES)
  {
    try {
      /* Ensure the key & IV is the same for both encrypt & decrypt. */
      if (!empty($text) && is_string($text)) {
        $text_num = str_split($text,$bit_check);
        $text_num = $bit_check - strlen($text_num[count($text_num) - 1]);

        for ($i=0; $i<$text_num; $i++)
          $text = $text . chr($text_num);

        $cipher = mcrypt_module_open($cypher_type,'','cbc','');
        mcrypt_generic_init($cipher, $key, $iv);
        $encrypted = mcrypt_generic($cipher,$text);
        mcrypt_generic_deinit($cipher);

        return base64_encode($encrypted);
      } else {
        return $text;
      }
    } catch (\Exception $e) {
      return 'Error: ' . $e->getMessage();
    }
  }

  /**
  * Decrypts $text based on your $key and $iv.  Make sure you use the same key
  * and initialization vector that you used when encrypting the $text.
  *
  * @param string $encrypted_text
  * @param string $key
  * @param string $iv
  * @param int $bit_check
  * @param string $cypher_type
  * @return string $text
  * @throws \Exception $e
  */
  public static function decrypt($encrypted_text,$key='',$iv='',$bit_check=8,$cypher_type=MCRYPT_TRIPLEDES)
  {
    try {
      /* Ensure the key & IV is the same for both encrypt & decrypt. */
      if (!empty($encrypted_text)) {
        $cipher = mcrypt_module_open($cypher_type,'','cbc','');
        mcrypt_generic_init($cipher, $key, $iv);
        $decrypted = mdecrypt_generic($cipher,base64_decode($encrypted_text));
        mcrypt_generic_deinit($cipher);
        $last_char=substr($decrypted,-1);
  
        for ($i=0; $i<$bit_check-1; $i++) {
          if (chr($i) == $last_char) {
            $decrypted=substr($decrypted,0,strlen($decrypted)-$i);
            break;
          }
        }
  
        return $decrypted;
      } else {
        return $encrypted_text;
      }
    } catch (\Exception $e) {
      return 'Error: ' . $e->getMessage();
    }
  }
}
