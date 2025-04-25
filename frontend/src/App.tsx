import {MainPage} from "./pages/MainPage.tsx";
import {BrowserRouter, Route, Routes} from "react-router";
import {LoginPage} from "./pages/LoginPage.tsx";
import {RegisterPage} from "./pages/RegisterPage.tsx";
import {AdminUserList} from "./pages/Admin/AdminUserList.tsx";
import {AdminUserDetails} from "./pages/Admin/AdminUserDetails.tsx";
import {Swiper} from "./pages/Swiper.tsx";
import {useDispatch} from "react-redux";
import {useEffect} from "react";
import {setToken} from "./store/authSlice.ts";
import {ProtectedRoute} from "./common/Routes/ProtectedRoute.tsx";

function App() {
    const dispatch = useDispatch();

    useEffect(() => {
        if (localStorage.getItem('token') !== null) {
            dispatch(setToken(localStorage.getItem('token') as string));
        }
    },[])

    return (
        <>
            <BrowserRouter>
                <Routes>
                    <Route path='/' element={<MainPage/>}/>
                    <Route path='/login' element={<LoginPage/>}/>
                    <Route path='/register' element={<RegisterPage/>}/>
                    <Route path='/admin/users' element={<AdminUserList/>}/>
                    <Route path='/admin/users/:userId' element={<AdminUserDetails/>}/>
                    <Route path='/swiper' element={
                        <ProtectedRoute>
                            <Swiper/>
                        </ProtectedRoute>
                    }/>


                </Routes>
            </BrowserRouter>
        </>
    )
}

export default App
