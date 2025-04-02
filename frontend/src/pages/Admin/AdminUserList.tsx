import {useEffect, useState} from "react";
import {action_get_users} from "../../common/actions/actions.ts";

function AdminUserList() {
    const [data,setData] = useState([])

    useEffect(() =>{
        action_get_users(setData)
    },[])


    return (
        <>
            {data.map((res,index)=> <div>
                Użytkownik {index+1}: {res.name} {res.surname}
            </div>)}
        </>
    )
}

export {AdminUserList}