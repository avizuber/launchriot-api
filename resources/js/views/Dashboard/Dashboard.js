import React, {Component} from 'react'
import Header from '../../components/Header/Header';
import Footer from '../../components/Footer/Footer';

class Dashboard extends Component {
  constructor() {
    super(props);

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
          <span>Whatever normally goes into the user dasboard page; the table below for instance</span> <br/>
          <table className="table table-striped">
            <tbody>
              <tr>
                <th scope="row ">User Id</th>
                <td>{user.id}</td>
              </tr>
              <tr>
                <th scope="row ">Full Name</th>
                <td>{user.name}</td>
              </tr>
              <tr>
                <th scope="row ">Email</th>
                <td>{user.email}</td>
              </tr>
            </tbody>
          </table>
        <Footer/>
      </div>
      )
    }
}
export default Dashboard