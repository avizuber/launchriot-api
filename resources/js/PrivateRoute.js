import React from 'react';
import {Redirect, Route, withRouter} from 'react-router-dom';

let authState = localStorage["appState"];

if (!authState){
  let appState = {
    isLoggedIn: false,
    user: {}
  };
  
  localStorage["appState"] = JSON.stringify(appState);
}

let AppState = JSON.parse(authState);

const Auth = {
  isLoggedIn: AppState.isLoggedIn,
  user: AppState
};

const PrivateRoute = ({ component: Component, path, ...rest }) => (
  <Route 
    path={path}
    {...rest}
    render={ props => 
      Auth.isLoggedIn ? 
        (
          <Component {...props} />
        ) 
      : (
          <Redirect
            to={
              {
                pathname: "/login",
               state: {
                 prevLocation: path,
                 error: "You need to login first!",
               },
              }
            }
          />
        )
    }
  />
);

export default withRouter(PrivateRoute);