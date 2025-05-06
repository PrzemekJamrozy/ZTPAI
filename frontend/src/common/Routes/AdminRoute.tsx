import {Navigate} from "react-router";
import {useSelector} from "react-redux";
import {RootState} from "../../store/store.ts";
import {ReactNode} from "react";
import {RolesEnum} from "../enums/RolesEnum.ts";

type Props = {
    children: ReactNode;
}

function AdminRoute({children}: Props) {
    const {roles} = useSelector((state: RootState) => state.user)

    if (roles.length === 0 || !roles.includes(RolesEnum.ADMIN)) {
        return <Navigate to='/' replace/>;
    }

    return children;
}

export {AdminRoute};