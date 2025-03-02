@extends('admin_student.master')


@section('extrastyles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.79/theme-default.min.css">
@endsection

@section('main')
  <div class="container-fluid">
    {{-- payment form --}}
    <div class="row mt-3">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <a href="{{ route('payment.history') }}" class="btn btn-info btn-md float-right">Payment History</a>
          </div>
          <div class="card-body">
            <form action="{{ route('student.makePyament') }}" method="post" enctype="multipart/form-data" data-cc-on-file="false" data-stripe-publishable-key="{{ config('constant.stripe_key') }}"
              id="payment-form">
              @csrf
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="">Payment Type: <span class="text-danger">*</span></label>
                  <select name="paidFor" class="form-control" id="paidFor" required>
                    <option value="" selected disabled>please choose...</option>
                    @foreach ($feeTypes as $item)
                      <option value="{{ $item->id }}">{{ $item->feeTitle }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-4">
                  <label for="">Payable Amount: <span class="text-danger">*</span> (Minimum Payable is selected)</label>
                  <input type="number" id="minimumPayable" class="form-control" name="amount" required>
                </div>
                <div class="form-group col-md-4">
                  <label for="">Payment Date:<span class="text-danger">*</span></label>
                  <input type="date" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" name="advancePayment" required>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="">Card Holder:</label>
                  <input type="text" name="cardName" class="form-control" autocomplete='off' required>
                </div>
                <div class="form-group col-md-6">
                  <label for="">Card Number:</label>
                  <input type="text" name="cardNumber" class="form-control card-number" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="">CVV:</label>
                  <input type="text" name="cvv" class="form-control card-cvc" required>
                </div>

                <div class="form-group col-md-6">
                  <label for="">Card Expiration:</label>
                  <input type="text" name="expMonth" class="datepicker form-control" id="card-expiry" required>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-12">
                  <button class="btn btn-success pull-right" type="submit">make payment</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('extrascript')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.79/jquery.form-validator.min.js"></script>
  <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

  <script>
    $(document).ready(function() {
      $.validate();
      $('.datepicker').datepicker({
        format: "mm-yyyy",
        startView: "months",
        minViewMode: "months",
        orientation: "top right",
        autoclose: true
      });
    });
  </script>

  <script>
    $(document).ready(function() {
      $("#paidFor").on("change", function() {
        var itemID = $("#paidFor").val();
        var path = "{{ route('pay.minimum') }}";
        //  console.log(itemID);
        $.ajax({
          type: "get",
          url: path,
          data: {
            'itemID': itemID
          },
          dataType: "json",
          success: function(response) {
            $("#minimumPayable").attr({
              "value": response,
              "min": response
            });
            // console.log(response);
          }
        });
      });
    });
  </script>
  {{-- stripe payment --}}
  <script>
    $("#payment-form").submit(function(e) {
      const cardExpiry = $("#card-expiry").val().split("-");
      console.log(cardExpiry);
      e.preventDefault();
      Stripe.setPublishableKey($("#payment-form").data('stripe-publishable-key'));
      Stripe.createToken({
        number: $('.card-number').val(),
        cvc: $('.card-cvc').val(),
        exp_month: cardExpiry[0],
        exp_year: cardExpiry[1]
      }, stripeResponseHandler);
    });

    function stripeResponseHandler(status, response) {
      if (response.error) {
        $('.error')
          .removeClass('hide')
          .find('.alert')
          .text(response.error.message);
      } else {
        // token contains id, last4, and card type
        var token = response['id'];
        // insert the token into the form so it gets submitted to the server
        $("#payment-form").find('input[type=text]').empty();
        $("#payment-form").append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
        $("#payment-form").get(0).submit();
      }
    }
  </script>
@endsection
