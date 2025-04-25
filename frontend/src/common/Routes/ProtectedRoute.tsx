import {Navigate} from "react-router";
import {useSelector} from "react-redux";
import {RootState} from "../../store/store.ts";

function ProtectedRoute({children}) {
    const token = useSelector((state: RootState) => state.auth.token);
    console.log(token)
    if(!token) {
        return <Navigate to='/' replace />;
    }

    return children;
}

export {ProtectedRoute};