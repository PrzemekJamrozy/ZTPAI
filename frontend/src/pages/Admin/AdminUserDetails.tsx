import {useParams} from "react-router";
import {useEffect, useState} from "react";
import {action_get_user} from "../../common/actions/actions.ts";

function AdminUserDetails(){
    const params = useParams();
    const [data,setData]= useState({});
    useEffect(()=>{
        action_get_user(params.userId, setData)
    },[])

    return (
        <>
            {Object.keys(data).length && <div>{data.name} {data.surname} {data.email} {data.status} {data.gender}</div>}
        </>
    )


}

export { AdminUserDetails }