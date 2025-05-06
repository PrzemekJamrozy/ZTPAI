import {createSlice, PayloadAction} from "@reduxjs/toolkit";
import {UserStatusEnum} from "../common/enums/UserStatusEnum.ts";
import {GenderEnum} from "../common/enums/GenderEnum.ts";
import {UserData} from "../common/actions/Responses.ts";
import {PreferredGenderEnum} from "../common/enums/PreferredGenderEnum.ts";
import {RolesEnum} from "../common/enums/RolesEnum.ts";

interface UserProfileState {
    preferredGender: PreferredGenderEnum;
    bio: string;
    fbLink: string
    igLink: string
    avatar: string
}


interface UserState {
    id: number;
    name: string;
    surname: string;
    email: string;
    status: UserStatusEnum;
    gender: GenderEnum;
    roles: RolesEnum[]
    profile: UserProfileState;
}

const initialState: UserState = {
    id: 0,
    name: "",
    surname: "",
    email: "",
    status: UserStatusEnum.UNKNOWN,
    gender: GenderEnum.MALE,
    roles: [],
    profile: {
        preferredGender: PreferredGenderEnum.MALE,
        bio:"",
        fbLink:"",
        igLink:"",
        avatar:"",
    }
}

const userSlice = createSlice({
    name: "auth",
    initialState,
    reducers: {
        setUser: (state, action: PayloadAction<UserData>) => {
            state.id = action.payload.id
            state.name = action.payload.name
            state.surname = action.payload.surname
            state.email = action.payload.email
            state.status = action.payload.status
            state.gender = action.payload.gender
            state.roles = action.payload.roles
            state.profile = action.payload.profile
        },
        resetUser: () => initialState,
    }
})

export const {setUser, resetUser} = userSlice.actions;

export default userSlice.reducer;