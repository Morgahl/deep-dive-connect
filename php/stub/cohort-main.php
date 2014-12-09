<?php
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("php/class/cohort.php");

$mysqli = MysqliConfiguration::getMysqli();

$cohorts = Cohort::getCohorts($mysqli);

echo "<div class=\"row\">";

foreach($cohorts as $index => $element) {
	echo "<a href=\"php/stub/cohort.php?cohort=" . $element->getCohortId() . "\" class=\"col-xs-4\">" . $element->getDescription() . "</p>";
}

echo "</div>";



//<body bgcolor="#FFFFFF" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0">
//<p>&nbsp;</p>
//<table width="90%" border="0" cellspacing="2" cellpadding="2" align="center">
//   <tr>
//      <td width="4" height="177"></td>
//      <td colspan="3" align="center" valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="4">
//
//         <!--Thumbnails with links below-->
//         <tr>
//            <td width="1" height="146">&nbsp;</td>
//            <td width="118" align="center" valign="top"> <p><img name="image" width="100" height="100"></p>
//               <p><a href="cohort-page1">Cohort 1</a></p></td>
//            <td width="3">&nbsp;</td>
//            <td width="126" align="center" valign="top"> <p><img name="image" width="100" height="100"></p>
//               <p><a href="cohort-page2">Cohort 2</a></p></td>
//            <td width="5">&nbsp;</td>
//            <td width="120" align="center" valign="top"> <p><img name="image" width="100" height="100"></p>
//               <p><a href="cohort-page3">Cohort 3</a></p></td>
//            <td width="7">&nbsp;</td>
//            <td width="114" align="center" valign="top"> <p><img name="image" width="100" height="100"></p>
//               <p><a href="cohort-page4">Cohort 4</a></p></td>
//            <td width="1">&nbsp;</td>
//            <td width="115" align="center" valign="top"> <p><img name="image" width="100" height="100"></p>
//               <p><a href="cohort-page5">Cohort 5</a></p></td>
//            <td width="1">&nbsp;</td>
//            <td width="119" align="center" valign="top"> <p><img name="image" width="100" height="100"></p>
//               <p><a href="cohort-page6">Cohort 6</a></p></td>
//         </tr>
//         <tr>
//            <td height="27">&nbsp;</td>
//            <td colspan="11" align="center" valign="top"> <hr noshade size="1">
//            </td>
//         </tr>
//      </table></td>
//      <td width="24">&nbsp;</td>
//   </tr>
//   <tr>
//      <td height="14"></td>
//      <td width="61"></td>
//      <td width="835"></td>
//      <td width="58"></td>
//      <td></td>
//   </tr>
//   <section>
//      <td height="254"></td>
//      <td></td>
//      <td valign="top"> <p>THIS IS A ROUGH TEMPLATE FOR THE PUBLIC PAGE FOR THE
//         COHORTS. PHOTOS OR OTHER INFO</p>
//         <p>&nbsp;</p>
//         <p>DATES OF COHORTS?</p>
//         <p>&nbsp;</p>
//         <p>GROUPS?</p>
//         <p>LOREM IPSUM.....LOREM IPSUM.....LOREM IPSUM.....LOREM IPSUM.....LOREM
//            IPSUM.....LOREM IPSUM.....</p>
//         <p>LOREM IPSUM.....LOREM IPSUM.....LOREM IPSUM.....LOREM IPSUM.....LOREM
//            IPSUM.....LOREM IPSUM.....<br>
//         </p></td>
//      <td></td>
//      <td></td>
//      <section>
//         <tr>
//            <td height="331"></td>
//            <td></td>
//            <td>&nbsp;</td>
//            <td></td>
//            <td></td>
//         </tr>
//</table>
//
//</body>
//</html>
