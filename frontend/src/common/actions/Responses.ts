import {UserStatusEnum} from "../enums/UserStatusEnum.ts";
import {GenderEnum} from "../enums/GenderEnum.ts";
import {PreferredGenderEnum} from "../enums/PreferredGenderEnum.ts";
import {RolesEnum} from "../enums/RolesEnum.ts";

type ErrorResponse = {
    success: false,
    status: number,
    data: string | object,
}


type SuccessResponse<T> = {
    success: true,
    status: number,
    data: T,
}

type ApiResponse<T> = Promise<SuccessResponse<T> | ErrorResponse>


// DATA
type LoginData = {
    token: string
}

type RegisterData = {
    message: string
}

type UserProfileData = {
    bio: string
    fbLink: string
    igLink: string
    preferredGender: PreferredGenderEnum
    avatar: string
}

type UserData = {
    id: number;
    name: string;
    surname: string;
    email: string;
    status: UserStatusEnum;
    gender: GenderEnum;
    roles: RolesEnum[]
    profile: UserProfileData
}

// RESPONSE

type LoginResponse = ApiResponse<LoginData>

type RegisterResponse = ApiResponse<RegisterData>

type AuthMeResponse = ApiResponse<UserData>
type UserResponse = ApiResponse<UserData>
type UserListResponse = ApiResponse<UserData[]>


export type {
    AuthMeResponse,
    LoginResponse,
    RegisterResponse,
    UserResponse,
    UserData,
    UserListResponse,
}