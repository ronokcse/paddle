<?php

// file_put_contents('paddle.txt', json_encode($_POST) , FILE_APPEND);
//reinsert value to $_POST
$_POST = json_decode('{"event_time":"2024-12-22 17:05:15","marketing_consent":"0","p_country":"BD","p_coupon":"","p_coupon_savings":"0.00","p_currency":"USD","p_custom_data":"","p_customer_email":"ronok@gmail.com","p_customer_name":"Ronok","p_earnings":"{\"5746\":\"14.2500\"}","p_order_id":"1018822","p_paddle_fee":"1.40","p_price":"18.00","p_product_id":"","p_quantity":"1","p_sale_gross":"18.00","p_tax_amount":"2.35","p_used_price_override":"1","quantity":"1","p_signature":"fK+WYIAX8Mx2E6z8uK8KgmqJXzTgxZ5z1oN80C0n7yAJiETxaJ8C6eWOytC8jlkQS2DDmLyilo4rcd28dp+tf\/E1adbpvYFItMNfoZZk4I2OQQ2ijjA+K+KlGU27VClEjUrcOKpf2OSthvXyohfArlXPsnwZ1mqMqzrY+1dE5XOclIK\/QmZ7ek0ateAKdEjC7umIufjLjefpkJGBREnapFLnCh9UK2mFVONiZkFp\/wV5tKjLVM05HgsHau4LES8cG9Vnn6oIZJlO5oPkr8gGDQAGyP71pzLtQXkDAG0DRXdgrlUfJhqlLwnf2WBmdKRwihjr2rqgFdiCZbFDg1D9NS0qc7LozfQFnK+1A\/vyWGGMCR23jU9vLbEah+22Xfb1e73R5Pi9sEV2DbFSLcYTBCXfMK6DRBV6msyhe5Ap2rTohK29hvouSeMsbLX19UHj7hS\/2OJojJHUOr9kUGLFUreeeTImyjGi8UlmPpgX0PAenSKK9Q0EZWNGhuX+RkT3AEo7EqPKg08rtJ4eCZvxRiXNQtF8CYLyhf+pFQWTTPgQIb0JdchKllN+08nkQDOXNvkkXH377CAQGbH+A2MpZ+zp2xr01xs1m+I0DU9zTF+rW3MwPZFcTVuA9JgEYYi10GoXyV86\/0eGjy7g0j6qVs9OGxU8lh39hpfDKeHMGGM="}',true);

// Your Paddle 'Public Key'

  $public_key = '-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAm31LkyxNIHgoTDX0wXUe
/W18+Ot/f9aWQ/bGiCE0JrSl4lXee3M8aL6cJgyYTksX67cWkfke5/RICTA2/CPa
/kRqlbNmPh5BRshK4ICB/poKxxWkX42f1yJ7r7cTIKkkcRcItd4uIKRc4lG6OMtI
JdaIVH3gvJerGHTvPK7gAp/SsWC2Pv9HFGekF89Dn0RbMpyD/S9I284Bam7+klCv
cUIjhOEJjDCURZFqIW6b5U2pZfijymP4hmYYKpSSmhgO1dEN+VsNQeaASGR2RW8g
IpZLNp+YiBVJaR5hHz35TUGa4KjR9bGLZKXDSOWxR0pSuCLkCV4yzbrixDNgPlu+
PT+vyFETHQ/LGnqKztt8w/PTXRWnFgTcpuf800KDvYOJ9GaASrFfSASqTL1BfDiA
MNXXzxJ4dsWpJhox2G968zd188xOglwEMgTyjD3dsyTJbFQ31s0Y2o/r9JjA6z8C
Qm7KXG5xJIsi72MMx5r358pW+vYgjdmd8X1+51GYA9WU3IRHJ8RRbqailJjEMKDR
u3Cr+9WTjJwYFB0OKYQj8xp9ChieRRKUu2kD1ciZCN27FFycPywTdS6qGt3rbfC9
3iNzH7aWMFzIR2/D+wHTuSfcmrcG50zmSC156rWAvEwEqQcjLYkJFjWHfC65VQds
59lL0qogJ0FEs1ts9g7SuIsCAwEAAQ==
-----END PUBLIC KEY-----';
  
  // Get the p_signature parameter & base64 decode it.
 $signature = base64_decode($_POST['p_signature']);

  
  // Get the fields sent in the request, and remove the p_signature parameter
  $fields = $_POST;
  unset($fields['p_signature']);
  
  // ksort() and serialize the fields
  ksort($fields);

  foreach($fields as $k => $v) {
	  if(!in_array(gettype($v), array('object', 'array'))) {
		  $fields[$k] = "$v";
	  }
  }
  $data = serialize($fields);

  
  // Verify the signature
  $verification = openssl_verify($data, $signature, $public_key, OPENSSL_ALGO_SHA1);
  
if ($verification != 1) {
    // We could not verify the Paddle webhook
    header('HTTP/1.0 200 Status');
    die('We could not verify the Paddle webhook');
}

 echo "response successfull";

