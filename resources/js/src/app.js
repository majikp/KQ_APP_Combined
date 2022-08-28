/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

require('./bootstrap');
import 'bootstrap/dist/css/bootstrap.min.css';


import './i18n';
import React from "react";
import ReactDOM from "react-dom";
import { MemoryRouter } from "react-router-dom";

import  Main from "./Main";
import Store from "./store"


ReactDOM.render(
    <Store>
        <MemoryRouter>
            <Main />
        </MemoryRouter>
    </Store>
  ,
  document.getElementById("root")
);
