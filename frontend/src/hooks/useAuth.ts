import {useEffect} from "react";
import {useDispatch} from "react-redux";
import {NavigateFunction} from "react-router";
import {action_auth_me} from "../common/actions/actions.ts";
import {clearToken, setIsAuthenticated, setIsCheckingToken, setToken} from "../store/authSlice.ts";


function useAuth(navigate: NavigateFunction) {
    const dispatch = useDispatch();
    useEffect(() => {
        const checkTokenState = async () => {
            const token = localStorage.getItem('token');
            // if token doesn't exist redirect to main page
            if(!token) {
                navigate('/')
                dispatch(setIsAuthenticated(false))
                dispatch(setIsCheckingToken(false))
                return;
            }
            dispatch(setToken(token))
            const result = await action_auth_me(token)

            console.log("udało sie")

            if (!result.success) {
                console.log("udało sie")
                navigate('/')
                localStorage.clear()
                dispatch(clearToken())

            }
            else{
                navigate('/swiper')
                dispatch(setIsAuthenticated(true))
                dispatch(setIsCheckingToken(false))
            }
        }
        checkTokenState()
    },[])

}

export { useAuth };