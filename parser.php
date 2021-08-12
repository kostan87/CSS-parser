<?php
function get_web_page( $url ) {
  $uagent = "Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.14";

  $ch = curl_init( $url );

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_ENCODING, "");
  curl_setopt($ch, CURLOPT_USERAGENT, $uagent);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
  curl_setopt($ch, CURLOPT_TIMEOUT, 120);
  curl_setopt($ch, CURLOPT_MAXREDIRS, 10);

  $content = curl_exec( $ch );
  $err     = curl_errno( $ch );
  $errmsg  = curl_error( $ch );
  $header  = curl_getinfo( $ch );
  curl_close( $ch );

  $header['errno']   = $err;
  $header['errmsg']  = $errmsg;
  $header['content'] = $content;
  return $header;
}

$url = 'http://htmlbook.ru/html/input';
if(isset($_POST['submit'])) {
  $url = $_POST['url'];
}
$data = get_web_page($url);
$code = $data['content'];
echo '<div hidden>';
print_r($data['content']);
echo '</div>';
?>

<style>
head, body {
  zoom: 0.8;
}
table {
  border-collapse: collapse;
  line-height: 1.1;
  font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
  background:  radial-gradient(farthest-corner at 50% 50%, white, #DCECF8);
  color: #0C213B;
}
caption {
  font-family: annabelle, cursive;
  font-weight: bold;
  font-size: 2em;
  padding: 10px;
  color: #F3CD26;
  text-shadow: 1px 1px 0 rgba(0,0,0,.3);
 }
caption:before, caption:after {
  content: "\274B";
  color: #A9E2CC;
  margin: 0 10px;
}
th {
  padding: 10px;
  border: 1px solid #A9E2CC;
}
td {
  font-size: 0.8em;
  padding: 5px 7px;
  border: 1px solid #A9E2CC;
}
</style>

<form method="post">
  <input type="text" name="url" placeholder="url">
  <input type="submit" name="submit">
</form>

<table>
<caption>Свойства элементов сайта <?php echo $url; ?></caption>
<tr>
  <th>#</th>
  <th>width</th>
  <th>height</th>
  <th>margin</th>
  <th>padding</th>
  <th>innerHTML</th>
</tr>

<script>
function css(elem, sel, match) {
  return getComputedStyle(document.getElementsByTagName(elem)[match])[sel];
}
function print_tr(elem) {
  let n = document.getElementsByTagName(elem).length
  for (let i = 1; i < n; i++) {
    document.write("<tr><td>"+elem+" "+document.getElementsByTagName(elem)[i].className+"</td><td>"+css(elem, 'width', i-1)+"</td><td>"+css(elem, 'height', i-1)+"</td><td>"+css(elem, 'margin', i-1)+"</td><td>"+css(elem, 'padding', i-1)+"</td><td>"+document.getElementsByTagName(elem)[i].innerHTML+"</td></tr>");
  }
}
print_tr('h1');
print_tr('p');
print_tr('div');
print_tr('span');
</script>
</table>