@extends('layouts.frontend-master')

@section('content')
    <section>

      <div class="container mt-5">
          <div class="row">
              <div class="col-md-5">
                  <h1>Contact Us</h1>
                  <ul class="list-unstyled">
                      <li class="mt-3">
                          <table>
                              <tbody>
                                  <tr>
                                      <th><i class="fa fa-map-marker" aria-hidden="true"></i></th>
                                      <td>
                                          Reraagents
                                          Vidyanagar 3rd line<br>
                                          Guntur,522034 <br>
                                          Andhara Pradesh <br>
                                          India
                                      </td>
                                  </tr>

                              </tbody>
                          </table>

                      </li>
                      <li class="mt-3">
                          <table>
                              <tbody>
                                  <tr>
                                      <th><i class="fa fa-phone" aria-hidden="true"></i></i></th>
                                      <td>
                                          +91 986 665 7007
                                      </td>
                                  </tr>

                              </tbody>
                          </table>
                      </li>
                      <li class="mt-3">
                          <table>
                              <tbody>
                                  <tr>
                                      <th><i class="fa fa-envelope" aria-hidden="true"></i></th>
                                      <td>
                                          support@reraagents.in
                                      </td>
                                  </tr>

                              </tbody>
                          </table>
                      </li>

                      <li class="mt-5">
                          <button class="btn btn2 my-2 my-sm-0" type="submit" style="width:16rem;">Post Your Requirement</button>
                      </li>

                      <li class="mt-3">
                          <a class="btn btn1 my-2 my-sm-0" href="{{ route('page.property.sell') }}" style="width:16rem;">Sell Your Property</a>
                      </li>

                  </ul>
              </div>

              <div class="col-md-7">
                  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3829.036714799458!2d80.4230420151626!3d16.321068188725796!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a358b104c88103d%3A0xa972dd486c9b9bfd!2sReraagents.in!5e0!3m2!1sen!2sin!4v1547465104773"
                      width="600" height="450" frameborder="0" style="border:0" allowfullscreen=""></iframe>
              </div>
          </div>
      </div>

    </section>
@endsection