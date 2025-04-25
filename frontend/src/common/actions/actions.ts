import {RegisterForm} from "../Forms/RegisterForm.ts";
import {requester} from "../Requester/Requester.ts";
import {BACKEND_URLS} from "../Requester/Links.ts";
import {AuthMeResponse, LoginResponse} from "./Responses.ts";
import {LoginForm} from "../Forms/LoginForm.ts";

const action_register = (data:RegisterForm) => {

    requester(BACKEND_URLS.REGISTER_URL,"POST",data)
        .then((res) => res.json())
        .then((res) => {
            console.log(res);
        })
}

const action_login = (data:LoginForm):LoginResponse => {
    return requester(BACKEND_URLS.LOGIN_URL,"POST",data)
        .then((res) => res.json())
}

const action_auth_me = async (token:string): AuthMeResponse => {
    const res = await fetch(`http://localhost:9001/api${BACKEND_URLS.AUTH_ME_URL}`,{
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${token}`,
        }
    });
    return await res.json();
}


export {
    action_register,
    action_auth_me,
    action_login,
}