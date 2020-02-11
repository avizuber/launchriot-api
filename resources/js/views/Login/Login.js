import React, {Component} from 'react';
import LoginContainer from './LoginContainer';
import {withRouter} from "react-router-dom";

class Login extends Component {
  constructor(props) {
    super(props);
    
    this.state = {
      redirect: props.location,
    };
  }
  
  render() {
    const { redirect } = this.state;
    return (
      <div className="content">
        <LoginContainer redirect={redirect} />
      </div>
    )
  } 
}

export default withRouter(Login)