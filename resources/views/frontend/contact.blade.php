@extends('layouts.frontend-master')

@section('content')
    <section>

      <div class="container mt-4">
          <div class="row mb-3">

              <div class="col-md-8 offset-md-2">
                    <h3>Want to say something?</h3>
                    <form action="https://formeasy.app/u/3ff32569-35a8-445c-ab7c-013a8afcb149" method="post" id="contact-form">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile no.</label>
                        <input type="number" id="mobile" class="form-control" name="mobile">
                    </div>
                    <div class="form-group">
                        <label for="purpose">Purpose</label>
                        <select class="form-control" id="purpose" name="purpose">
                            <option value="">Choose your subject</option>
                            <option value="Looking for franchise">Looking for franchise</option>
                            <option value="Job opening">Job opening</option>
                            <option value="Miscellaneous">Miscellaneous</option>
                        </select>
                    </div>
                    <input type="text" name="hrhka802526sdasd6f501" style="display:none">
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="5"></textarea>
                    </div>
                    <input type="hidden" name="_redirect_url" value="{{ route('page.thankyou') }}">
                    <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                </form>
              </div>

          </div>
      </div>

    </section>
@endsection

@section('javascript')
    <script src="{{asset('js/jquery.validate.js') }}"></script>
    <script>
        $('#contact-form').validate({
            rules: {
                name: 'required',
                mobile: {
                    required: true,
                    minlength: 10
                },
                purpose: 'required',
                message: {
                    required: true,
                    minlength: 20
                }
            },
            messages: {
                name: 'Name is required.',
                mobile: {
                    required: 'Mobile no is required.',
                    minlength: "Mobile no is too short"
                },
                purpose: 'Select your subject',
                message: {
                    required: 'Message is required.',
                    minlength: 'Message is too short (minimum 20 characters)'
                }
            }
        })
    </script>
@endsection