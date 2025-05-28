import {MainPage} from "./pages/MainPage.tsx";
import {BrowserRouter, Route, Routes} from "react-router";
import {LoginPage} from "./pages/LoginPage.tsx";
import {RegisterPage} from "./pages/RegisterPage.tsx";
import {AdminUserList} from "./pages/Admin/AdminUserList.tsx";
import {Swiper} from "./pages/Swiper.tsx";
import {useDispatch} from "react-redux";
import {useEffect, useState} from "react";
import {setToken} from "./store/authSlice.ts";
import {ProtectedRoute} from "./common/Routes/ProtectedRoute.tsx";
import {NotFound} from "./pages/NotFound.tsx";
import {UserProfile} from "./pages/UserProfile.tsx";
import {AdminUserEdit} from "./pages/Admin/AdminUserEdit.tsx";
import {UserEdit} from "./pages/UserEdit.tsx";
import {ToastProvider} from "./hooks/useToast.tsx";
import {GuestRoute} from "./common/Routes/GuestRoute.tsx";
import {action_auth_me} from "./common/actions/actions.ts";
import {setUser} from "./store/userSlice.ts";
import {Matches} from "./pages/Matches.tsx";
import {Spinner} from "./components/Spinner.tsx";
import {AdminRoute} from "./common/Routes/AdminRoute.tsx";
import {OnboardingPage} from "./pages/OnboardingPage.tsx";

function App() {
    const dispatch = useDispatch();
    const [isLoading, setIsLoading] = useState(true);
    useEffect(() => {
        const _handleRequest = async () => {
            const result = await action_auth_me()
            if (result.success) {
                dispatch(setUser(result.data))
            }else{
                localStorage.clear()
                window.location.href = '/'
            }
            setIsLoading(false)
        }

        const token = localStorage.getItem('token');
        if (token !== null) {
            dispatch(setToken(token));
            _handleRequest()
        } else {
            setIsLoading(false)
        }
    }, [])

    return (
        <>
            {isLoading && <Spinner/>}
            {!isLoading &&
                <ToastProvider>
                    <BrowserRouter>
                        <Routes>
                            <Route path='/' element={
                                <GuestRoute>
                                    <MainPage/>
                                </GuestRoute>
                            }/>
                            <Route path='/login' element={
                                <GuestRoute>
                                    <LoginPage/>
                                </GuestRoute>
                            }/>
                            <Route path='/register' element={
                                <GuestRoute>
                                    <RegisterPage/>
                                </GuestRoute>}/>
                            <Route path='/user/profile' element={
                                <ProtectedRoute>
                                    <UserProfile/>
                                </ProtectedRoute>
                            }/>
                            <Route path='/user/onboarding' element={
                                <ProtectedRoute>
                                    <OnboardingPage/>
                                </ProtectedRoute>
                            }/>
                            <Route path='/user/edit' element={
                                <ProtectedRoute>
                                    <UserEdit/>
                                </ProtectedRoute>
                            }/>
                            <Route path='/swiper' element={
                                <ProtectedRoute>
                                    <Swiper/>
                                </ProtectedRoute>
                            }/>
                            <Route path='/matches' element={
                                <ProtectedRoute>
                                    <Matches/>
                                </ProtectedRoute>
                            }/>
                            <Route path='/admin/users' element={
                                <ProtectedRoute>
                                    <AdminRoute>
                                        <AdminUserList/>
                                    </AdminRoute>
                                </ProtectedRoute>
                            }/>
                            <Route path='/admin/users/:userId/edit' element={
                                <ProtectedRoute>
                                    <AdminRoute>
                                        <AdminUserEdit/>
                                    </AdminRoute>
                                </ProtectedRoute>
                            }/>
                            <Route path="*" element={<NotFound/>}/>
                        </Routes>
                    </BrowserRouter>
                </ToastProvider>}

        </>
    )
}

export default App
