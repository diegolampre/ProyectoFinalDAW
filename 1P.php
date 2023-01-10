<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://www.paypal.com/sdk/js?client-id=Abh2mFAoZA1ceS4G6YRnxHupw0ODVqeEFSLyw3QFE0EtAAbnVwTP2o4GBk-rEibqzF2Pi5seUr0ThrRM&currency=EUR"></script>
</head>
<body>
    <div id="paypal-button-container"></div>

    <script>
        paypal.Buttons({
            style:{
                color: 'blue',
                label: 'pay'
            },
            createOrder: function(data, actions){
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: 100
                        }
                    }]
                });
            },

            onApprove: function(data, actions){
                actions.order.capture().then(function (detalles){
                    window.location.href="completado.php"
                    console.log(detalles);
                });
            },

            onCancel: function(data){
                alert("Pago cancelado");
                console.log(data);
            }
        }).render('#paypal-button-container')
    </script>
</body>
</html>