import React, {Component} from 'react';
import {Link, withRouter} from 'react-router-dom';
import ReactDOM from 'react-dom';
import FlashMessage from 'react-flash-message';

class RegisterContainer extends Component {
  // 2.1
  constructor(props) {
    super(props);

    let localAuthState = localStorage["appState"];

    let authState;
    if(localAuthState) {
      authState = JSON.parse(localAuthState);
    }
    
    this.state = {
      isLoggedIn: authState && authState.isLoggedIn,
      isRegistered: false,
      error: '',
      errorMessage: '',
      formSubmitting: false,
      user: {
        f_name: authState ? authState.f_name : '',
        l_name: authState ? authState.l_name : '',
        email: authState ? authState.email : '',
        password: '',
        password_confirmation: '',
      },
      redirect: props.redirect,
      appState: localStorage["appState"]
    };
}

componentDidMount() {
  const { redirect, isLoggedIn } = this.state;
  const { prevLocation } = redirect.state || { prevLocation: { pathname: '/dashboard' } };
  
  if (prevLocation && isLoggedIn) {
    return this.props.history.push(prevLocation);
  }
}

handleSubmit = (e) => {
  e.preventDefault();

  const { user } = this.state;
  let userData = user;
  
  this.setState({ formSubmitting: true });
  
  ReactDOM.findDOMNode(this).scrollIntoView();
  
  axios.post("/api/auth/signup", userData)
    .then(response => {
      return response;
  }).then(json => {
      if (json.data.success) {
        let userData = {
          id: json.data.id,
          f_name: json.data.f_name,
          l_name: json.data.l_name,
          email: json.data.email,
          activation_token: json.data.activation_token,
        };

        let appState = {
          isRegistered: true,
          user: userData
        };

        localStorage["appState"] = JSON.stringify(appState);
        
        this.setState({
          isRegistered: appState.isRegistered,
          user: appState.user
        });
      } else {
          alert(`Our System Failed To Register Your Account!`);
      }
 }).catch(error => {if (error.response) {
      // The request was made and the server responded with a status code that falls out of the range of 2xx
      let err = error.response.data;
      this.setState({
        error: err.message,
        errorMessage: err.errors,
        formSubmitting: false
      })
    }
    else if (error.request) {
      // The request was made but no response was received `error.request` is an instance of XMLHttpRequest in the browser and an instance of http.ClientRequest in node.js
      let err = error.request;
      this.setState({
        error: err,
        formSubmitting: false
      })
   } else {
       // Something happened in setting up the request that triggered an Error
       let err = error.message;
       this.setState({
         error: err,
         formSubmitting: false
       })
   }
 }).finally(this.setState({error: ''}));
}

handleFirstName = (e) => {
  let value = e.target.value;
  this.setState(prevState => ({
    user: {
      ...prevState.user, f_name: value
    }
  }));
}

handleLastName = (e) => {
  let value = e.target.value;
  this.setState(prevState => ({
    user: {
      ...prevState.user, l_name: value
    }
  }));
}

// 2.5
handleEmail = (e) => {
  let value = e.target.value;
  this.setState(prevState => ({
    user: {
      ...prevState.user, email: value
    }
  }));
}

handlePassword = (e) => {
  let value = e.target.value;
  this.setState(prevState => ({
    user: {
      ...prevState.user, password: value
    }
  }));
}

handlePasswordConfirm = (e) => {
  let value = e.target.value;
  this.setState(prevState => ({
    user: {
      ...prevState.user, password_confirmation: value
    }
  }));
}

render() {
  let { error, errorMessage, isRegistered, formSubmitting } = this.state;
  let errorArr = [];
  
  errorMessage && Object.values(errorMessage).forEach((value) => (
    errorArr.push(value)
  ));
  
  return (
    <div className="container">
      <div className="row">
        <div className="offset-xl-3 col-xl-6 offset-lg-1 col-lg-10 col-md-12 col-sm-12 col-12 ">
          <h2>Create Your Account</h2>

        {isRegistered && 
          <FlashMessage duration={60000} persistOnHover={true}>
            <h5 className={"alert alert-success"}>Registration successful, redirecting...</h5>
          </FlashMessage>
        }

        {error && 
          <FlashMessage duration={900000} persistOnHover={true}>
            <h5 className={"alert alert-danger"}>Error: {error}</h5>
            <ul>
              {errorArr.map((errorMsg, i) => (
                <li key={i}><h5 style={{color: 'red'}}>{errorMsg}</h5></li>
               ))}
            </ul>
          </FlashMessage> 
        }

          <form onSubmit={this.handleSubmit}>
            <div className="form-group">
              <input id="f_name" type="text" placeholder="First Name" className="form-control" required onChange={this.handleFirstName}/>
            </div>
            <div className="form-group">
              <input id="l_name" type="text" placeholder="Last Name" className="form-control" required onChange={this.handleLastName}/>
            </div>
            <div className="form-group">
              <input id="email" type="email" name="email" placeholder="E-mail" className="form-control" required onChange={this.handleEmail}/>
            </div>
            <div className="form-group">
              <input id="password" type="password" name="password" placeholder="Password" className="form-control" required onChange={this.handlePassword}/>
            </div>
            <div className="form-group">
              <input id="password_confirm" type="password" name="password_confirm" placeholder="Confirm Password" className="form-control" required onChange={this.handlePasswordConfirm} />
            </div>
            <button type="submit" name="singlebutton" className="btn btn-default btn-lg  btn-block mb10" disabled={formSubmitting ? "disabled" : ""}>Create Account</button>
          </form>
          <p className="text-white">Already have an account?
            <Link to="/login" className="text-yellow"> Log In</Link>
            <span className="pull-right"><Link to="/" className="text-white">Back to Home</Link></span>
          </p>
        </div>
      </div>
    </div>
    )
  }
}

export default withRouter(RegisterContainer);