import {LoginForm} from "../Forms/LoginForm.ts";

type ErrorResponse = {
    success: false,
    status: number,
    data: string,
}


type SuccessResponse<T> = {
    success: true,
    status: number,
    data: T,
}

type ApiResponse<T> = Promise<SuccessResponse<T> | ErrorResponse>

type AuthMeResponse = ApiResponse<{name:string}>

type LoginData = {
    token: string
}

type LoginResponse = ApiResponse<LoginData>


export type {AuthMeResponse,LoginResponse}