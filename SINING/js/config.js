async;
src = "https://pay.google.com/gp/p/js/pay.js";
onload = "console.log('TODO: add onload function')";

const paymentsClient = new google.payments.api.PaymentsClient({
  environment: "TEST",
});

const isReadyToPayRequest = Object.assign({}, baseRequest);
isReadyToPayRequest.allowedPaymentMethods = [baseCardPaymentMethod];

paymentsClient
  .isReadyToPay(isReadyToPayRequest)
  .then(function (response) {
    if (response.result) {
      // add a Google Pay payment button
    }
  })
  .catch(function (err) {
    // show error in developer console for debugging
    console.error(err);
  });

const button = paymentsClient.createButton({
  onClick: () => console.log("TODO: click handler"),
  allowedPaymentMethods: [],
}); // same payment methods as for the loadPaymentData() API call
document.getElementById("container").appendChild(button);

const allowedCardNetworks = [
  "AMEX",
  "DISCOVER",
  "INTERAC",
  "JCB",
  "MASTERCARD",
  "VISA",
];
const baseRequest = {
  apiVersion: 2,
  apiVersionMinor: 0,
};
const tokenizationSpecification = {
  type: "PAYMENT_GATEWAY",
  parameters: {
    gateway: "easypay",
    gateway: "mpgs",
    gatewayMerchantId: "SINING",
  },
};
const allowedCardAuthMethods = ["PAN_ONLY", "CRYPTOGRAM_3DS"];

const baseCardPaymentMethod = {
  type: "CARD",
  parameters: {
    allowedAuthMethods: allowedCardAuthMethods,
    allowedCardNetworks: allowedCardNetworks,
  },
};

const cardPaymentMethod = Object.assign(
  { tokenizationSpecification: tokenizationSpecification },
  baseCardPaymentMethod
);
