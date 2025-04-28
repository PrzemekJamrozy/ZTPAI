import {MainPage} from "./pages/MainPage.tsx";
import {BrowserRouter, Route, Routes} from "react-router";
import {LoginPage} from "./pages/LoginPage.tsx";
import {RegisterPage} from "./pages/RegisterPage.tsx";
import {AdminUserList} from "./pages/Admin/AdminUserList.tsx";
import {Swiper} from "./pages/Swiper.tsx";
import {useDispatch} from "react-redux";
import {useEffect} from "react";
import {setToken} from "./store/authSlice.ts";
import {ProtectedRoute} from "./common/Routes/ProtectedRoute.tsx";
import {NotFound} from "./pages/NotFound.tsx";
import {UserProfile} from "./pages/UserProfile.tsx";
import {AdminUserEdit} from "./pages/Admin/AdminUserEdit.tsx";
import {UserEdit} from "./pages/UserEdit.tsx";

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
                    <Route path='/user/profile' element={<UserProfile/>}/>
                    <Route path='/user/edit' element={<UserEdit/>}/>
                    <Route path='/swiper' element={
                        <ProtectedRoute>
                            <Swiper/>
                        </ProtectedRoute>
                    }/>
                    <Route path='/admin/users' element={<AdminUserList/>}/>
                    <Route path='/admin/users/:userId/edit' element={<AdminUserEdit/>}/>
                    <Route path="*" element={<NotFound/>}/>

                </Routes>
            </BrowserRouter>
        </>
    )
}

export default App
