import React from 'react';
import logo from './logo.svg';
import './App.css';
import {BrowserRouter, Route, Routes} from "react-router";
import MainPage from "./pages/MainPage";

function App() {
  return (
      <BrowserRouter>
        <Routes>
            <Route path="/" element={<MainPage/>}/>
            <Route path="/login" element={<MainPage/>}/>
            <Route path="/register" element={<MainPage/>}/>
            <Route path="/matches" element={<MainPage/>}/>
            <Route path="/user-profile" element={<MainPage/>}/>
            <Route path="/edit-profile" element={<MainPage/>}/>
            <Route path="admin">
                <Route index element={<MainPage/>}/>
                <Route path="/edit-profile/:id" element={<MainPage/>}/>
            </Route>
        </Routes>
      </BrowserRouter>
  );
}

export default App;
