<p>決済ページへリダイレクトします。</p>
<script src="https://js.stripe.com/v3/"></script>
<script src="js/payment.js"></script>
<script>
    const publicKey = '{{ $publicKey }}';
    const stripe = Stripe(publicKey);
    window.onload = function() {
        stripe.redirectToCheckout({
            sessionId: '{{ $session->id }}'
        }).then(function (result) {
            window.location.href = 'http://localhost/cart';
            // http://localhost:8080/Laravel/techpit-clothes-workspace/techpit-clothes/public/cart
        });
    }
</script>