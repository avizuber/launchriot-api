import React, {Component} from 'react';
import RegisterContainer from './RegisterContainer';

class Register extends Component {
  constructor(props) {
    super(props);
    
    this.state = {
      redirect: props.location,
    }
  }

  render() {
    const { redirect } = this.state;
    return (
      <div className="content">
        <RegisterContainer redirect={redirect} />
      </div>
    )
  }
}

export default Register