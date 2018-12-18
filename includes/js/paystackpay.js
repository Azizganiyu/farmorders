  function alert(){alert('hello');}
  function payWithPaystack(){
    var handler = PaystackPop.setup({
      // This assumes you already created a constant named
      // PAYSTACK_PUBLIC_KEY with your public key from the
      // Paystack dashboard. You can as well just paste it
      // instead of creating the constant
      key: 'pk_live_25a55e1e03523167ed69aa016acfcd2178c40e04',
      email: 'azizganiyu0@gmail.com',
      amount: '1000',
      metadata: {
        cartid: orderObj.cartid,
        custom_fields: [
          {
            display_name: "Paid on",
            variable_name: "paid_on",
            value: 'Website'
          },
          {
            display_name: "Paid via",
            variable_name: "paid_via",
            value: 'Inline Popup'
          }
        ]
      },
      callback: function(response){
        // post to server to verify transaction before giving value
        alert('success. transaction ref is ' + response);
      },
      onClose: function(){
        alert('Click "Pay now" to retry payment.');
      }
    });
    handler.openIframe();
  }