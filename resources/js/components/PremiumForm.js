import React, { Component } from 'react';
import MultiSelect from "@khanacademy/react-multi-select";
import ReactDOM from 'react-dom';
import axios from 'axios';

export default class PremiumForm extends Component {

  constructor(props) {
    super(props);
    this.state = {
      property: {

      },
      amenities: [
      ],

      feature_one_first_line: '',
      feature_one_second_line: '',
      feature_two_first_line: '',
      feature_two_second_line: '',
      feature_three_first_line: '',
      feature_three_second_line: '',
      feature_four_first_line: '',
      feature_four_second_line: '',
      overview: '',
      youtube_link: '',
      website: '',
      google_map: '',

      formError: {
        feature_one_first_line: 'This field is required',
        feature_one_second_line: 'This field is required',
        feature_two_first_line: 'This field is required',
        feature_two_second_line: 'This field is required',
        feature_three_first_line: 'This field is required',
        feature_three_second_line: 'This field is required',
        feature_four_first_line: 'This field is required',
        feature_four_second_line: 'This field is required',
        overview: 'This field is required',
      },
      imgPreview: [],
      floorPlanPreview: [],
      isLoading: false,
      touched: false,
      selectedAmenities: []
    }

    this.handleChange = this.handleChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
    this.handleFileChange = this.handleFileChange.bind(this);
  }

  componentDidMount() {
    this.fetchPropertyData();
    this.fetchAmenities();
  }

  fetchPropertyData() {
    axios(this.props.url, {
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
        Authorization: `Bearer ${this.props.token}`
      },
      params: {
        id: this.props.id
      }
    })
      .then(response => {
        console.log(response.data.data);
        let property = response.data.data;

        const features = JSON.parse(property.highlights);

        this.setState({
          ...this.state,
          feature_one_first_line: features['feature_one']['line_one'],
          feature_one_second_line: features['feature_one']['line_two'],
          feature_two_first_line: features['feature_two']['line_one'],
          feature_two_second_line: features['feature_two']['line_two'],
          feature_three_first_line: features['feature_three']['line_one'],
          feature_three_second_line: features['feature_three']['line_two'],
          feature_four_first_line: features['feature_four']['line_one'],
          feature_four_second_line: features['feature_four']['line_two'],
          website: property.website,
          youtube_link: property.youtube_link,
          google_map: property.google_map,
          overview: property.overview,
          selectedAmenities: property.amenities.split(',').map(amenity => +amenity)
        }, console.log(this.state))

      })
      .catch(err => {
        console.log(err);
      })
  }

  fetchAmenities() {
    axios(this.props.amenitiesUrl, {
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
        Authorization: `Bearer ${this.props.token}`
      }
    })
      .then(response => {
        // let property = response.data;
        let data = response.data.data;
        // console.log(data);
        let amenities = data.map(a => {
          return {
            label: a.name,
            value: a.id
          }
        });
        // console.log(amenities);
        this.setState({ amenities: amenities });

      })
      .catch(err => {
        console.log(err);
      })
  }

  handleChange(e) {
    const { name, value } = e.target;
    this.setState({ [name]: value },
      () => { this.validateField(name, value) });
  }

  handleSubmit(e) {
    e.preventDefault();
    const { formError } = this.state;
    let isFormValid = true;
    for (let err in formError) {
      if (formError[err] !== '') {
        isFormValid = false;
      }
    }

    if (!isFormValid) {
      this.setState({ ...this.state, isFormValid, touched: true });
    } else {
      let formData = new FormData();

      formData.append('website', this.state.website ? this.state.website : '');
      formData.append('youtube_link', this.state.youtube_link ? this.state.youtube_link : '');
      formData.append('google_map', this.state.google_map ? this.state.google_map : '');
      formData.append('features', this.state.features ? this.state.features : '');
      formData.append('overview', this.state.overview ? this.state.overview : '');
      formData.append('amenities', this.state.selectedAmenities ? this.state.selectedAmenities : '');

      this.state.imgPreview.map(function (img) {
        console.log(img)
        formData.append('images', img.file, img.file.name);
      });

      this.state.floorPlanPreview.map(function (img) {
        formData.append('floorplans', img.file, img.file.name);
      });

      let highlights = JSON.stringify({
        feature_one: {
          line_one: this.state.feature_one_first_line,
          line_two: this.state.feature_one_second_line,
        },
        feature_two: {
          line_one: this.state.feature_two_first_line,
          line_two: this.state.feature_two_second_line,
        },
        feature_three: {
          line_one: this.state.feature_three_first_line,
          line_two: this.state.feature_three_second_line,
        },
        feature_four: {
          line_one: this.state.feature_four_first_line,
          line_two: this.state.feature_four_second_line,
        },
      });

      formData.append('highlights', highlights);
      formData.append('id', this.props.id);
      // console.log(this.state);
      axios(this.props.url, {
        method: 'post',
        headers: {
          Authorization: `Bearer ${this.props.token}`
        },
        data: formData
      })
        .then(function (response) {
          console.log(response.data);
        })
        .catch(err => {
          console.log(err);
        })
    }
  }

  validateField(field, value) {
    let { formError } = this.state;

    switch (field) {
      case ('feature_one_first_line'):
        if (!value) {
          this.setState({ formError: { ...formError, feature_one_first_line: 'This field is required' } });
        } else {
          this.setState({ formError: { ...formError, feature_one_first_line: '' } });
        }
        break;

      case ('feature_one_second_line'):
        if (!value) {
          this.setState({ formError: { ...formError, feature_one_second_line: 'This field is required' } });
        } else {
          this.setState({ formError: { ...formError, feature_one_second_line: '' } });
        }
        break;

      case ('feature_two_first_line'):
        if (!value) {
          this.setState({ formError: { ...formError, feature_two_first_line: 'This field is required' } });
        } else {
          this.setState({ formError: { ...formError, feature_two_first_line: '' } });
        }
        break;

      case ('feature_two_second_line'):
        if (!value) {
          this.setState({ formError: { ...formError, feature_two_second_line: 'Email is invalid' } });
        } else {
          this.setState({ formError: { ...formError, feature_two_second_line: '' } });
        }
        break;

      case ('feature_three_first_line'):
        if (!value) {
          this.setState({ formError: { ...formError, feature_three_first_line: 'This field is required' } });
        } else {
          this.setState({ formError: { ...formError, feature_three_first_line: '' } });
        }
        break;

      case ('feature_three_second_line'):
        if (!value) {
          this.setState({ formError: { ...formError, feature_three_second_line: 'This field is invalid' } });
        } else {
          this.setState({ formError: { ...formError, feature_three_second_line: '' } });
        }
        break;

      case ('feature_four_first_line'):
        if (!value) {
          this.setState({ formError: { ...formError, feature_four_first_line: 'This field is required' } });
        } else {
          this.setState({ formError: { ...formError, feature_four_first_line: '' } });
        }
        break;

      case ('feature_four_second_line'):
        if (!value) {
          this.setState({ formError: { ...formError, feature_four_second_line: 'This field is invalid' } });
        } else {
          this.setState({ formError: { ...formError, feature_four_second_line: '' } });
        }
        break;

      case ('overview'):
        console.log('ov', field)
        if (!value) {
          this.setState({ formError: { ...formError, overview: 'This field is invalid' } });
        } else {
          this.setState({ formError: { ...formError, overview: '' } });
        }
        break;

      default:
        break;
    }
  }

  handleFileChange(e) {
    console.log(e.target.files);
    const files = Array.from(e.target.files);
    
    if (e.target.name == 'floorPlan') {

      let img = [];
      files.forEach(function (f) {
        let reader = new FileReader();
        reader.onloadend = () => {
          img.push({
            file: f,
            previewUrl: reader.result
          });
        }
        reader.readAsDataURL(f);
      });
      this.setState({ floorPlanPreview: img });

    } else {
      let img = [];
      files.forEach(function (f) {
        let reader = new FileReader();
        reader.onloadend = () => {
          img.push({
            file: f,
            previewUrl: reader.result
          });
        }
        reader.readAsDataURL(f);
      });
      this.setState({ imgPreview: img });
    }
  }

  render() {
    return (
      <div>
        <form autoComplete="off" method="POST" onSubmit={this.handleSubmit}>

          <div className="form-group">
            <label htmlFor="website">Website</label>
            <input type="text" className={['form-control', this.state.formError.website ? 'is-invalid' : ''].join(' ')} id="website" name="website" value={this.state.website} onChange={this.handleChange} />

            {/* @if ($errors->has('website'))
                <span className="invalid-feedback" role="alert">
                <strong>{{ $errors-> first('website')}}</strong>
              </span>
              @endif */}
          </div>

          <div className="form-group">
            <label htmlFor="youtube_link">Youtube link</label>
            <input type="text" className="form-control {{ $errors->has('youtube_link') ? ' is-invalid' : '' }}" id="youtube_link" name="youtube_link" value={this.state.youtube_link} onChange={this.handleChange} />

            {/* @if ($errors->has('youtube_link'))
              <span className="invalid-feedback" role="alert">
                <strong>{{ $errors-> first('youtube_link')}}</strong>
              </span>
              @endif */}
          </div>

          <div className="form-group">
            <label htmlFor="google_map">Google map</label>
            <input type="text" className="form-control {{ $errors->has('google_map') ? ' is-invalid' : '' }}" id="google_map" name="google_map" value={this.state.google_map} onChange={this.handleChange} />

            {/* @if ($errors->has('google_map'))
                  <span className="invalid-feedback" role="alert">
                    <strong>{{ $errors-> first('google_map')}}</strong>
                  </span>
                @endif */}
          </div>

          <div className="form-group mb-4">
            <label htmlFor="images">Property images</label>
            <div className="custom-file">
              <input type="file" className="custom-file-input{{ $errors->has('images') ? ' is-invalid' : '' }}" id="images" name="images[]" multiple accept="image/*" onChange={this.handleFileChange}/>
              <label className="custom-file-label" htmlFor="images">Choose file</label>
            </div>
          </div>

          <div className="form-group">
            <label htmlFor="features">Highlights</label>
            <textarea name="features" id="features" rows="3" className="form-control">
              {this.state.features}
            </textarea>

            {/* @if ($errors->has('features'))
                <span className="invalid-feedback" role="alert">
                  <strong>{{ $errors-> first('features')}}</strong>
                </span>
              @endif */}
          </div>

          <div className="row">
            <div className="col-md-6">
              <div className="form-group">
                <label htmlFor="feature_one_first_line">Feature 1 (First line)</label>
                <input type="text" id="feature_one_first_line" name="feature_one_first_line" className={['form-control', this.state.formError.feature_one_first_line && this.state.touched ? 'is-invalid' : ''].join(' ')} value={this.state.feature_one_first_line} onChange={this.handleChange} />

                {this.state.formError.feature_one_first_line && this.state.touched ? (
                  <span className="invalid-feedback" role="alert">
                    <strong>{this.state.formError.feature_one_first_line}</strong>
                  </span>
                ) : null}

              </div>
            </div>

            <div className="col-md-6">
              <div className="form-group">
                <label htmlFor="feature_one_second_line">Feature 1 (Second line)</label>
                <input type="text" id="feature_one_second_line" name="feature_one_second_line" className={['form-control', this.state.formError.feature_one_second_line && this.state.touched ? 'is-invalid' : ''].join(' ')} value={this.state.feature_one_second_line} onChange={this.handleChange} />

                {this.state.formError.feature_one_second_line && this.state.touched ? (
                  <span className="invalid-feedback" role="alert">
                    <strong>{this.state.formError.feature_one_second_line}</strong>
                  </span>
                ) : null}

              </div>
            </div>

          </div>

          <div className="row">
            <div className="col-md-6">
              <div className="form-group">
                <label htmlFor="feature_two_first_line">Feature 2 (First line)</label>
                <input type="text" id="feature_two_first_line" name="feature_two_first_line" className={['form-control', this.state.formError.feature_two_first_line && this.state.touched ? 'is-invalid' : ''].join(' ')} value={this.state.feature_two_first_line} onChange={this.handleChange} />

                {this.state.formError.feature_two_first_line && this.state.touched ? (
                  <span className="invalid-feedback" role="alert">
                    <strong>{this.state.formError.feature_two_first_line}</strong>
                  </span>
                ) : null}

              </div>
            </div>

            <div className="col-md-6">
              <div className="form-group">
                <label htmlFor="feature_two_second_line">Feature 2 (Second line)</label>
                <input type="text" id="feature_two_second_line" name="feature_two_second_line" className={['form-control', this.state.formError.feature_two_second_line && this.state.touched ? 'is-invalid' : ''].join(' ')} value={this.state.feature_two_second_line} onChange={this.handleChange} />
                {this.state.formError.feature_two_second_line && this.state.touched ? (
                  <span className="invalid-feedback" role="alert">
                    <strong>{this.state.formError.feature_two_second_line}</strong>
                  </span>
                ) : null}
              </div>
            </div>
          </div>

          <div className="row">
            <div className="col-md-6">
              <div className="form-group">
                <label htmlFor="feature_three_first_line">Feature 3 (First line)</label>
                <input type="text" id="feature_three_first_line" name="feature_three_first_line" className={['form-control', this.state.formError.feature_three_first_line && this.state.touched ? 'is-invalid' : ''].join(' ')} value={this.state.feature_three_first_line} onChange={this.handleChange} />

                {this.state.formError.feature_three_first_line && this.state.touched ? (
                  <span className="invalid-feedback" role="alert">
                    <strong>{this.state.formError.feature_three_first_line}</strong>
                  </span>
                ) : null}

              </div>
            </div>

            <div className="col-md-6">
              <div className="form-group">
                <label htmlFor="feature_three_second_line">Feature 3 (Second line)</label>
                <input type="text" id="feature_three_second_line" name="feature_three_second_line" className={['form-control', this.state.formError.feature_three_second_line && this.state.touched ? 'is-invalid' : ''].join(' ')} value={this.state.feature_three_second_line} onChange={this.handleChange} />
                {this.state.formError.feature_three_second_line && this.state.touched ? (
                  <span className="invalid-feedback" role="alert">
                    <strong>{this.state.formError.feature_three_second_line}</strong>
                  </span>
                ) : null}
              </div>
            </div>
          </div>

          <div className="row">
            <div className="col-md-6">
              <div className="form-group">
                <label htmlFor="feature_four_first_line">Feature 4 (First line)</label>
                <input type="text" id="feature_four_first_line" name="feature_four_first_line" className={['form-control', this.state.formError.feature_four_first_line && this.state.touched ? 'is-invalid' : ''].join(' ')} value={this.state.feature_four_first_line} onChange={this.handleChange} />

                {this.state.formError.feature_four_first_line && this.state.touched ? (
                  <span className="invalid-feedback" role="alert">
                    <strong>{this.state.formError.feature_four_first_line}</strong>
                  </span>
                ) : null}
              </div>
            </div>

            <div className="col-md-6">
              <div className="form-group">
                <label htmlFor="feature_four_second_line">Feature 4 (Second line)</label>
                <input type="text" id="feature_four_second_line" name="feature_four_second_line" className={['form-control', this.state.formError.feature_four_second_line && this.state.touched ? 'is-invalid' : ''].join(' ')} value={this.state.feature_four_second_line} onChange={this.handleChange} />

                {this.state.formError.feature_four_second_line && this.state.touched ? (
                  <span className="invalid-feedback" role="alert">
                    <strong>{this.state.formError.feature_four_second_line}</strong>
                  </span>
                ) : null}

              </div>
            </div>
          </div>

          <div className="form-group">
            <label htmlFor="overview">Overview</label>
            <textarea name="overview" id="overview" rows="5" className={['form-control', this.state.formError.overview && this.state.touched ? 'is-invalid' : ''].join(' ')} value={this.state.overview} onChange={this.handleChange}>
            </textarea>

            {this.state.formError.overview && this.state.touched ? (
              <span className="invalid-feedback" role="alert">
                <strong>{this.state.formError.overview}</strong>
              </span>
            ) : null}

            {/* @if ($errors->has('features'))
                <span className="invalid-feedback" role="alert">
                  <strong>{{ $errors-> first('features')}}</strong>
                </span>
              @endif */}
          </div>

          <div className="form-group mb-4">
            <label htmlFor="floorPlan">Floor plans</label>
            <div className="custom-file">
              <label className="custom-file-label" htmlFor="images">Choose floor plans</label>
              <input type="file" className="custom-file-input" id="floorPlan" name="floorPlan[]" multiple accept="image/*" onChange={this.handleFileChange} />
            </div>
          </div>

          <div className="form-group">
            <label htmlFor="amenities">Amenities</label>
            <MultiSelect
              options={this.state.amenities}
              selected={this.state.selectedAmenities}
              onSelectedChanged={selected => {console.log(selected); this.setState({ selectedAmenities: selected })}}
            />
          </div>


          <button className="btn btn-gradient-primary mt-3" type="submit">Update property</button>
        </form>
      </div>
    );
  }
}

if (document.getElementById('premium-form')) {
  var id = $('#premium-form').attr('data-id');
  var token = $('#premium-form').attr('data-token');
  var url = $('#premium-form').attr('data-url');
  var amenitiesUrl = $('#premium-form').attr('data-amenities-url');
  ReactDOM.render(<PremiumForm id={id} token={token} url={url} amenitiesUrl={amenitiesUrl} />, document.getElementById('premium-form'));
}
