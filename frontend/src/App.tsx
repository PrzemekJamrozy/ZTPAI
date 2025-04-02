import {MainPage} from "./pages/MainPage.tsx";
import {BrowserRouter, Route, Routes} from "react-router";
import {LoginPage} from "./pages/LoginPage.tsx";
import {RegisterPage} from "./pages/RegisterPage.tsx";
import {AdminUserList} from "./pages/Admin/AdminUserList.tsx";
import {AdminUserDetails} from "./pages/Admin/AdminUserDetails.tsx";

function App() {
  return (
   <BrowserRouter>
       <Routes>
           <Route path='/' element={<MainPage/>} />
           <Route path='/login' element={<LoginPage/>} />
           <Route path='/register' element={<RegisterPage/>} />
           <Route path='/admin/users' element={<AdminUserList/>} />
           <Route path='/admin/users/:userId' element={<AdminUserDetails/>} />
       </Routes>
   </BrowserRouter>
  )
}

export default App
