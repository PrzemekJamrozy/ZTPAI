import {Navigate} from "react-router";
import {useSelector} from "react-redux";
import {RootState} from "../../store/store.ts";
import {ReactNode} from "react";

type Props = {
    children: ReactNode;
}

function ProtectedRoute({children}: Props) {
    const token = useSelector((state: RootState) => state.auth.token);
    if(!token) {
        return <Navigate to='/' replace />;
    }

    return children;
}

export {ProtectedRoute};