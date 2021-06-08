// the key will not get defined on the backend so let's use Stripe sample key:
if ( typeof(dceStripePublishableKey) === "undefined" ) {
	var dceStripePublishableKey = 'pk_test_TYooMQauvdEDq54NiTphI7jx';
}

const stripe = Stripe(dceStripePublishableKey);

function makeElementsStyle(style) {
	return {
		base: {
			color: style.color,
			fontFamily: style.fontFamily + ' sans-serif',
			fontSmoothing: "antialiased",
			fontSize: style.fontSize,
			fontWeight: style.fontWeight,
			fontStyle: style.fontStyle,
			"::placeholder": {
				color: "#aab7c4"
			}
		},
		invalid: {
			color: "#fa755a",
			iconColor: "#fa755a"
		},
	};
}

function initializeStripeField(wrapper, $scope) {
	const $form = $scope.find('form');
    	const $submitButton = $scope.find('.elementor-field-type-submit button');
	const $wrapper = jQuery(wrapper);
	const $hiddenInput = $wrapper.find('input');
	const $error = $wrapper.find('.stripe-error');
	const elements = stripe.elements();
	const $elementsWrapper = $wrapper.find('.dce-stripe-elements');
	const clientSecret = $elementsWrapper.attr('data-cs');
	const required = $elementsWrapper.attr('data-required') === 'true';
	const style = makeElementsStyle( {
		color: $elementsWrapper.css('color'),
		fontFamily: $elementsWrapper.css('font-family'),
		fontSize: $elementsWrapper.css('font-size'),
		fontWeight: $elementsWrapper.css('font-weight'),
		fontStyle: $elementsWrapper.css('font-style'),
	});
	const cardElement = elements.create('card', {style: style, hidePostalCode: false });
	const isCardEmpty = () => {
		return $elementsWrapper.hasClass('StripeElement--empty');
	}
	cardElement.mount($elementsWrapper[0]);
	$form.on('submit', (event) => {
		// if invisibile because conditional fields:
		if ( wrapper.style.display === 'none') {
			return;
		}
		if ( !required && isCardEmpty() ) {
			return;
		}
		if ( $hiddenInput.val() ) {
			return; // already processed.
		}
		event.preventDefault();
		event.stopImmediatePropagation();
		$submitButton.attr('disabled', 'disabled');
		$error.hide();
		stripe.confirmCardPayment( clientSecret, { payment_method: {
			type: 'card',
			card: cardElement,
		}}).then((result) => {
			if (result.error) {
				$submitButton.removeAttr('disabled');
				$error.text(result.error.message);
				$error.show();
			} else {
				$error.hide();
				$hiddenInput.val(result.paymentIntent.id);
				$form.trigger('submit');
			}
		});
	});
}

function initializeAllStripeFields($scope) {
	$scope.find('.elementor-field-type-dce_form_stripe').each((_, w) => initializeStripeField(w, $scope));
}

jQuery(window).on('elementor/frontend/init', function() {
	elementorFrontend.hooks.addAction('frontend/element_ready/form.default', initializeAllStripeFields);
});
