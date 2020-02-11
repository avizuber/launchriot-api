import React, {Component} from 'react'
import Header from '../Header/Header';
import Footer from '../Footer/Footer';

class Home extends Component {
  constructor() {
    super();

    let localAuthState = localStorage["appState"];

    let authState;
    if(localAuthState) {
      authState = JSON.parse(localAuthState);
    }

    this.state = {
      isLoggedIn: authState && authState.isLoggedIn,
      user: authState ? authState.user : {},
    }
  }

  render() {
    const { user, isLoggedIn } = this.state;
    return (
      <div>
        <Header userData={user} userIsLoggedIn={isLoggedIn}/>
          <span>Whatever normally goes into the home/index page; A Plea To Heal The World for instance</span>
        <Footer/>
      </div>
    )
  }

}

export default Home