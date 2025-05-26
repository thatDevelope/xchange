@extends('userdashboard.index') <!-- Extend your dashboard layout -->

@section('content')
<style>
    .section-lead {
    font-size: 1.2rem;
    font-weight: 600;
    color: #fff;
    background: linear-gradient(135deg, #FF416C, #FF4B2B);
    padding: 15px 20px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease-in-out;
}

.section-lead:hover {
    transform: scale(1.05);
}

.highlight {
    color: #ffd700;
    font-weight: bold;
    text-transform: uppercase;
    display: inline-block;
    padding: 3px 5px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 5px;
}

</style>


<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Currency exchange</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
              <div class="breadcrumb-item"><a href="#">Forms</a></div>
              <div class="breadcrumb-item">Currency</div>
            </div>
          </div>

          <div class="section-body">
            <h2 class="section-title">Currency Exchange</h2>
            <p class="section-lead">
  Your exchange is secured. 
  <span class="highlight">However, please double-check all details before clicking the 'Approve' button.</span> Once payment is made to the person you're paired with, it cannot be reversed.
</p>


            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                @if(session('success'))
    <div class="alert alert-success mt-2">
        {{ session('success') }}
    </div>
@endif
                  <div class="card-header">
      
                    <h4>Input Text</h4>
                  </div>
                  <div class="card-body">
      <form action="{{ route('currency-orders.store') }}" method="POST">
            @csrf
                  <div class="form-group">
    <label for="currency">Select Currency You Have</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">💱</span> <!-- Currency Icon -->
        </div>
        <select class="form-control" name="currency" id="currency_from">
            @foreach($currencies as $currency)
                <option value="{{ strtolower($currency['alpha3']) }}">
                    {{ $currency['alpha3'] }} - {{ $currency['name'] }}
                </option>
            @endforeach
        </select>
    </div>
</div>


<div class="form-group">
    <label>Currency Amount</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="fas fa-dollar-sign"></i> <!-- Currency Icon -->
            </div>
        </div>
        <input type="number" class="form-control" name="currency_amount" id="currency_amount" placeholder="Enter amount" step="0.01" min="0">
    </div>
</div>

<div class="form-group">
    <label for="currency">Select Currency You Need</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">💱</span> <!-- Currency Icon -->
        </div>
        <select class="form-control" name="exchange_currency" id="currency_to">
            @foreach($currencies as $currency)
                <option value="{{ strtolower($currency['alpha3']) }}">
                    {{ $currency['alpha3'] }} - {{ $currency['name'] }}
                </option>
            @endforeach
        </select>
    </div>
</div>
                    <div class="form-group">
                      <label>Exchange_amount</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            $
                          </div>
                        </div>
                        <input type="text" class="form-control currency" id="exchange_amount" name="exchange_amount" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Exchange_rate</label>
                      <input type="text" class="form-control purchase-code" id="exchange_rate" placeholder="Exchange rate will appear here" name="exchange_rate" readonly>
                    </div>

                    <div class="form-group">
                      <label>location</label>
                      <input type="text" class="form-control purchase-code" id="location" placeholder="Type your location" name="location" >
                    </div>
                    
                    <div class="form-group">
                      <label>Total_price</label>
                      <input type="text" class="form-control invoice-input">
                    </div>

                    <button class="btn btn-primary">Submit</button>
                </form>
             
                    <!-- <div class="form-group">
                      <label>Date</label>
                      <input type="text" class="form-control datemask" placeholder="YYYY/MM/DD">
                    </div> -->
                    <!-- <div class="form-group">
                      <label>Credit Card</label>
                      <input type="text" class="form-control creditcard">
                    </div> -->
                    <!-- <div class="form-group">
                      <label>Tags</label>
                      <input type="text" class="form-control inputtags">
                    </div> -->
                  </div>
                </div>
                <!-- <div class="card">
                  <div class="card-header">
                    <h4>Toggle Switches</h4>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <div class="control-label">Toggle switches</div>
                      <div class="custom-switches-stacked mt-2">
                        <label class="custom-switch">
                          <input type="radio" name="option" value="1" class="custom-switch-input" checked>
                          <span class="custom-switch-indicator"></span>
                          <span class="custom-switch-description">Option 1</span>
                        </label>
                        <label class="custom-switch">
                          <input type="radio" name="option" value="2" class="custom-switch-input">
                          <span class="custom-switch-indicator"></span>
                          <span class="custom-switch-description">Option 2</span>
                        </label>
                        <label class="custom-switch">
                          <input type="radio" name="option" value="3" class="custom-switch-input">
                          <span class="custom-switch-indicator"></span>
                          <span class="custom-switch-description">Option 3</span>
                        </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="control-label">Toggle switch single</div>
                      <label class="custom-switch mt-2">
                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description">I agree with terms and conditions</span>
                      </label>
                    </div>
                  </div>
                </div> -->
                <!-- <div class="card">
                  <div class="card-header">
                    <h4>Image Check</h4>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label class="form-label">Image Check</label>
                      <div class="row gutters-sm">
                        <div class="col-6 col-sm-4">
                          <label class="imagecheck mb-4">
                            <input name="imagecheck" type="checkbox" value="1" class="imagecheck-input"  />
                            <figure class="imagecheck-figure">
                              <img src="assets/img/news/img01.jpg" alt="}" class="imagecheck-image">
                            </figure>
                          </label>
                        </div>
                        <div class="col-6 col-sm-4">
                          <label class="imagecheck mb-4">
                            <input name="imagecheck" type="checkbox" value="2" class="imagecheck-input"  checked />
                            <figure class="imagecheck-figure">
                              <img src="assets/img/news/img02.jpg" alt="}" class="imagecheck-image">
                            </figure>
                          </label>
                        </div>
                        <div class="col-6 col-sm-4">
                          <label class="imagecheck mb-4">
                            <input name="imagecheck" type="checkbox" value="3" class="imagecheck-input"  />
                            <figure class="imagecheck-figure">
                              <img src="assets/img/news/img03.jpg" alt="}" class="imagecheck-image">
                            </figure>
                          </label>
                        </div>
                        <div class="col-6 col-sm-4">
                          <label class="imagecheck mb-4">
                            <input name="imagecheck" type="checkbox" value="4" class="imagecheck-input"  checked />
                            <figure class="imagecheck-figure">
                              <img src="assets/img/news/img04.jpg" alt="}" class="imagecheck-image">
                            </figure>
                          </label>
                        </div>
                        <div class="col-6 col-sm-4">
                          <label class="imagecheck mb-4">
                            <input name="imagecheck" type="checkbox" value="5" class="imagecheck-input"  />
                            <figure class="imagecheck-figure">
                              <img src="assets/img/news/img05.jpg" alt="}" class="imagecheck-image">
                            </figure>
                          </label>
                        </div>
                        <div class="col-6 col-sm-4">
                          <label class="imagecheck mb-4">
                            <input name="imagecheck" type="checkbox" value="6" class="imagecheck-input"  />
                            <figure class="imagecheck-figure">
                              <img src="assets/img/news/img06.jpg" alt="}" class="imagecheck-image">
                            </figure>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> -->
                <!-- <div class="card">
                  <div class="card-header">
                    <h4>Color</h4>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label>Simple</label>
                      <input type="text" class="form-control colorpickerinput">
                    </div>
                    <div class="form-group">
                      <label>Pick Your Color</label>
                      <div class="input-group colorpickerinput">
                        <input type="text" class="form-control">
                        <div class="input-group-append">
                          <div class="input-group-text">
                            <i class="fas fa-fill-drip"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Color Input</label>
                      <div class="row gutters-xs">
                        <div class="col-auto">
                          <label class="colorinput">
                            <input name="color" type="checkbox" value="primary" class="colorinput-input" />
                            <span class="colorinput-color bg-primary"></span>
                          </label>
                        </div>
                        <div class="col-auto">
                          <label class="colorinput">
                            <input name="color" type="checkbox" value="secondary" class="colorinput-input" />
                            <span class="colorinput-color bg-secondary"></span>
                          </label>
                        </div>
                        <div class="col-auto">
                          <label class="colorinput">
                            <input name="color" type="checkbox" value="danger" class="colorinput-input" />
                            <span class="colorinput-color bg-danger"></span>
                          </label>
                        </div>
                        <div class="col-auto">
                          <label class="colorinput">
                            <input name="color" type="checkbox" value="warning" class="colorinput-input" />
                            <span class="colorinput-color bg-warning"></span>
                          </label>
                        </div>
                        <div class="col-auto">
                          <label class="colorinput">
                            <input name="color" type="checkbox" value="info" class="colorinput-input" />
                            <span class="colorinput-color bg-info"></span>
                          </label>
                        </div>
                        <div class="col-auto">
                          <label class="colorinput">
                            <input name="color" type="checkbox" value="success" class="colorinput-input" />
                            <span class="colorinput-color bg-success"></span>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> -->
              </div>
              <!-- <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Select</h4>
                  </div>
                  <div class="card-body">
                    <div class="section-title mt-0">Default</div>
                    <div class="form-group">
                      <label>Default Select</label>
                      <select class="form-control">
                        <option>Option 1</option>
                        <option>Option 2</option>
                        <option>Option 3</option>
                      </select>
                    </div>
                    <div class="section-title">Select 2</div>
                    <div class="form-group">
                      <label>Select2</label>
                      <select class="form-control select2">
                        <option>Option 1</option>
                        <option>Option 2</option>
                        <option>Option 3</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Select2 Multiple</label>
                      <select class="form-control select2" multiple="">
                        <option>Option 1</option>
                        <option>Option 2</option>
                        <option>Option 3</option>
                        <option>Option 4</option>
                        <option>Option 5</option>
                        <option>Option 6</option>
                      </select>
                    </div>
                    <div class="section-title">jQuery Selectric</div>
                    <div class="form-group">
                      <label>jQuery Selectric</label>
                      <select class="form-control selectric">
                        <option>Option 1</option>
                        <option>Option 2</option>
                        <option>Option 3</option>
                        <option>Option 4</option>
                        <option>Option 5</option>
                        <option>Option 6</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>jQuery Selectric Multiple</label>
                      <select class="form-control selectric" multiple="">
                        <option>Option 1</option>
                        <option>Option 2</option>
                        <option>Option 3</option>
                        <option>Option 4</option>
                        <option>Option 5</option>
                        <option>Option 6</option>
                      </select>
                    </div>
                    <div class="section-title">Select Group Button</div>
                    <div class="form-group">
                      <label class="form-label">Size</label>
                      <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                          <input type="radio" name="value" value="50" class="selectgroup-input" checked="">
                          <span class="selectgroup-button">S</span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="radio" name="value" value="100" class="selectgroup-input">
                          <span class="selectgroup-button">M</span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="radio" name="value" value="150" class="selectgroup-input">
                          <span class="selectgroup-button">L</span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="radio" name="value" value="200" class="selectgroup-input">
                          <span class="selectgroup-button">XL</span>
                        </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Icons input</label>
                      <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                          <input type="radio" name="transportation" value="2" class="selectgroup-input">
                          <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-mobile"></i></span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="radio" name="transportation" value="1" class="selectgroup-input" checked="">
                          <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-tablet"></i></span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="radio" name="transportation" value="6" class="selectgroup-input">
                          <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-laptop"></i></span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="radio" name="transportation" value="6" class="selectgroup-input">
                          <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-times"></i></span>
                        </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Icon input</label>
                      <div class="selectgroup selectgroup-pills">
                        <label class="selectgroup-item">
                          <input type="radio" name="icon-input" value="1" class="selectgroup-input" checked="">
                          <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-sun"></i></span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="radio" name="icon-input" value="2" class="selectgroup-input">
                          <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-moon"></i></span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="radio" name="icon-input" value="3" class="selectgroup-input">
                          <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-cloud-rain"></i></span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="radio" name="icon-input" value="4" class="selectgroup-input">
                          <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-cloud"></i></span>
                        </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Your skills</label>
                      <div class="selectgroup selectgroup-pills">
                        <label class="selectgroup-item">
                          <input type="checkbox" name="value" value="HTML" class="selectgroup-input" checked="">
                          <span class="selectgroup-button">HTML</span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="checkbox" name="value" value="CSS" class="selectgroup-input">
                          <span class="selectgroup-button">CSS</span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="checkbox" name="value" value="PHP" class="selectgroup-input">
                          <span class="selectgroup-button">PHP</span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="checkbox" name="value" value="JavaScript" class="selectgroup-input">
                          <span class="selectgroup-button">JavaScript</span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="checkbox" name="value" value="Ruby" class="selectgroup-input">
                          <span class="selectgroup-button">Ruby</span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="checkbox" name="value" value="Ruby" class="selectgroup-input">
                          <span class="selectgroup-button">Ruby</span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="checkbox" name="value" value="C++" class="selectgroup-input">
                          <span class="selectgroup-button">C++</span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <h4>Toggle Switches</h4>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <div class="control-label">Toggle switches</div>
                      <div class="custom-switches-stacked mt-2">
                        <label class="custom-switch">
                          <input type="radio" name="option" value="1" class="custom-switch-input" checked>
                          <span class="custom-switch-indicator"></span>
                          <span class="custom-switch-description">Option 1</span>
                        </label>
                        <label class="custom-switch">
                          <input type="radio" name="option" value="2" class="custom-switch-input">
                          <span class="custom-switch-indicator"></span>
                          <span class="custom-switch-description">Option 2</span>
                        </label>
                        <label class="custom-switch">
                          <input type="radio" name="option" value="3" class="custom-switch-input">
                          <span class="custom-switch-indicator"></span>
                          <span class="custom-switch-description">Option 3</span>
                        </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="control-label">Toggle switch single</div>
                      <label class="custom-switch mt-2">
                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description">I agree with terms and conditions</span>
                      </label>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <h4>Date &amp; Time Picker</h4>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label class="d-block">Date Range Picker With Button</label>
                      <a href="javascript:;" class="btn btn-primary daterange-btn icon-left btn-icon"><i class="fas fa-calendar"></i> Choose Date
                      </a>
                    </div>
                    <div class="form-group">
                      <label>Date Picker</label>
                      <input type="text" class="form-control datepicker">
                    </div>
                    <div class="form-group">
                      <label>Date Time Picker</label>
                      <input type="text" class="form-control datetimepicker">
                    </div>
                    <div class="form-group">
                      <label>Date Range Picker</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-calendar"></i>
                          </div>
                        </div>
                        <input type="text" class="form-control daterange-cus">
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Time Picker</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-clock"></i>
                          </div>
                        </div>
                        <input type="text" class="form-control timepicker">
                      </div>
                    </div>
                  </div>
                </div>
              </div> -->
            </div>
          </div>

          

          <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
         
        
          <script>
$(document).ready(function () {
    let fromCurrency = '';
    let toCurrency = '';
    let currentRate = 0; // 💰 Store the exchange rate for calculation

    // Function to fetch exchange rate
    function fetchExchangeRate() {
        if (!fromCurrency || !toCurrency) {
            $("#exchange_rate").val(""); // Clear input
            return;
        }

        $.ajax({
            url: "/exchange-rate/" + fromCurrency.toUpperCase() + "/" + toCurrency.toUpperCase(),
            type: "GET",
            dataType: "json",
            success: function (response) {
                if (response.exchange_rate) {
                    currentRate = parseFloat(response.exchange_rate); // 💾 Save rate
                    $("#exchange_rate").val(currentRate);
                    calculateExchangeAmount(); // ⏱ Calculate if amount is already filled
                } else {
                    currentRate = 0;
                    $("#exchange_rate").val("Unavailable");
                    $("#exchange_amount").val('');
                }
            },
            error: function () {
                currentRate = 0;
                $("#exchange_rate").val("Error fetching rate");
                $("#exchange_amount").val('');
            }
        });
    }

    // When currency_from is changed
    $("#currency_from").on("change", function () {
        fromCurrency = $(this).val();
        fetchExchangeRate();
    });

    // When currency_to is changed
    $("#currency_to").on("change", function () {
        toCurrency = $(this).val();
        fetchExchangeRate();
    });

    // 🧮 Calculate converted amount
    function calculateExchangeAmount() {
        let amount = parseFloat($("#currency_amount").val());
        if (!isNaN(amount) && currentRate > 0) {
            let result = amount * currentRate;
            $("#exchange_amount").val(result.toFixed(2));
        } else {
            $("#exchange_amount").val('');
        }
    }

    // Trigger calculation when amount input changes
    $("#currency_amount").on("input", function () {
        calculateExchangeAmount();
    });
});
</script>




@endsection        
