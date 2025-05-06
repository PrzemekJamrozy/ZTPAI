import {configureStore} from "@reduxjs/toolkit";
import authSlice from "./authSlice.ts";
import userSlice from "./userSlice.ts";


export const store = configureStore({
    reducer: {
        auth: authSlice,
        user: userSlice
    }
});

export type RootState = ReturnType<typeof store.getState>;
export type AppDispatch = typeof store.dispatch;