import {createSlice, PayloadAction} from "@reduxjs/toolkit";

interface AuthState {
    token: string|null;
    isAuthenticated: boolean;
    isCheckingToken: boolean;
}

const initialState: AuthState = {
    token: null,
    isAuthenticated: false,
    isCheckingToken: true,
}

const authSlice = createSlice({
    name: "auth",
    initialState,
    reducers:{
        setToken: (state, action:PayloadAction<string>) => {
            state.token = action.payload;
        },
        clearToken: (state) => {
            state.token = '';
        },
        setIsAuthenticated: (state, action:PayloadAction<boolean>) => {
            state.isAuthenticated = action.payload;
        },
        setIsCheckingToken: (state, action:PayloadAction<boolean>) => {
            state.isCheckingToken = action.payload;
        },
        resetAuth: () => initialState,
    }
})

export const {setToken, clearToken, setIsAuthenticated, setIsCheckingToken, resetAuth} = authSlice.actions;

export default authSlice.reducer;