<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<title>A simple, clean, and responsive HTML invoice template</title>

		<!-- Favicon -->
		<link rel="icon" href="./images/favicon.png" type="image/x-icon" />

		<!-- Invoice styling -->
		<style>
			body {
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				text-align: center;
				color: #777;
			}

			body h1 {
				font-weight: 300;
				margin-bottom: 0px;
				padding-bottom: 0px;
				color: #000;
			}

			body h3 {
				font-weight: 300;
				margin-top: 10px;
				margin-bottom: 20px;
				font-style: italic;
				color: #555;
			}

			body a {
				color: #06f;
			}

			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
				border-collapse: collapse;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}
		</style>
	</head>

	<body>
         <div class="invoice-box">
			<table>
				<tr class="top">
				   <td colspan="2">
						<table>
							<tr>
								<td class="title">
									<img src="https://i.postimg.cc/dQfHtmRN/DDDDDDDDDDDDDDDDDDDDDDDD.jpg" alt="Company logo" style="width: 100%; max-width: 300px" />
								</td>
                              
								<td colspan="3">
									Invoice #:{{$order_id}}<br/>
									Created:{{App\Models\Order::find($order_id)->created_at}}<br/>
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
				       <td colspan="2">
						<table>
							<tr>
							   <td colspan="4">
								   {{App\Models\BillingDetails::where('order_id', $order_id)->first()->address}}
								</td>
                              <td class="4">
								{{App\Models\BillingDetails::where('order_id', $order_id)->first()->company_name}}<br />
								{{App\Models\BillingDetails::where('order_id', $order_id)->first()->name}}<br />
								{{App\Models\BillingDetails::where('order_id', $order_id)->first()->email}}
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="heading">
					<td>Item</td>
					<td>Price</td>
					<td>Quantity</td>
					<td>SubTotal</td>
				</tr>
				@foreach (App\Models\OrderProduct::where('order_id', $order_id)->get() as $product)
				<tr class="item">
					<td>{{$product->rel_to_product->product_name}}</td>
					<td>{{$product->product_price}}</td>
					<td>{{$product->quantity}}</td>
					<td>{{$product->product_price*$product->quantity}}</td>
				</tr>
				@endforeach 
				  <tr class="total">
					<td></td>

					<td>Discount:{{App\Models\Order::find($order_id)->discount}}</td>
				  </tr>
				  <tr class="total">
					<td></td>

					<td >Delivery Charge:{{App\Models\Order::find($order_id)->delivery_charge}}</td>
				  </tr>
				  <tr class="total">
					<td></td>

					<td>Total: {{App\Models\Order::find($order_id)->total}}</td>
				</tr>
			</table>
		</div>
	</body>
</html>