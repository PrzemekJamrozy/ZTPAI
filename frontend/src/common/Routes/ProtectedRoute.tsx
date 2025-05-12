import {Navigate, useLocation} from "react-router";
import {useSelector} from "react-redux";
import {RootState} from "../../store/store.ts";
import {ReactNode} from "react";
import {UserStatusEnum} from "../enums/UserStatusEnum.ts";

type Props = {
    children: ReactNode;
}

function ProtectedRoute({children}: Props) {
    const token = useSelector((state: RootState) => state.auth.token);
    const {status} = useSelector((state: RootState) => state.user);
    const location = useLocation();
    if(!token) {
        return <Navigate to='/' replace />;
    }

    if(status === UserStatusEnum.DURING_REGISTRATION && location.pathname !== "/user/onboarding") {
        return <Navigate to='/user/onboarding' replace />;
    }
    return children;
}

export {ProtectedRoute};