import {RegisterForm} from "../Forms/RegisterForm.ts";
import {requester} from "../Requester/Requester.ts";
import {BACKEND_URLS} from "../Requester/Links.ts";
import {AuthMeResponse, LoginResponse, RegisterResponse, UserResponse, UserListResponse} from "./Responses.ts";
import {LoginForm} from "../Forms/LoginForm.ts";
import {AdminEditUserForm, EditUserForm} from "../Forms/EditUserForm.ts";

const action_register = async (data: RegisterForm): RegisterResponse => {
    return requester(BACKEND_URLS.REGISTER_URL, "POST", data)
        .then((res) => res.json())
}

const action_login = async (data: LoginForm): LoginResponse => {
    return requester(BACKEND_URLS.LOGIN_URL, "POST", data)
        .then((res) => res.json())
}

const action_auth_me = async (): AuthMeResponse => {
    return requester(BACKEND_URLS.AUTH_ME_URL, "GET")
        .then((res) => res.json())
}

const action_update_user = async (userId: number, data: EditUserForm): UserResponse => {
    return requester(`${BACKEND_URLS.USERS_URL}/${userId}`, "PUT", data)
        .then((res) => res.json())
}

const action_get_potential_matches = async (): UserListResponse => {
    return requester(BACKEND_URLS.POTENTIAL_MATCHES_URL, "GET")
        .then((res) => res.json())
}

const action_get_matches = async (): UserListResponse => {
    return requester(BACKEND_URLS.MATCHES_URL, "GET")
        .then((res) => res.json())
}

const action_admin_get_users = async (): UserListResponse => {
    return requester(BACKEND_URLS.ADMIN_USERS_URL, "GET")
        .then((res) => res.json())
}

const action_admin_get_user = async (userId: number): UserResponse => {
    return requester(`${BACKEND_URLS.ADMIN_USERS_URL}/${userId}`, "GET")
        .then((res) => res.json())
}

const action_admin_update_user = async (userId: number, data: AdminEditUserForm): UserResponse => {
    return requester(`${BACKEND_URLS.ADMIN_USERS_URL}/${userId}`, "PUT", data)
        .then((res) => res.json())
}

export {
    action_register,
    action_auth_me,
    action_login,
    action_update_user,
    action_get_matches,
    action_admin_get_users,
    action_admin_get_user,
    action_admin_update_user,
    action_get_potential_matches
}