import {AdminUserListItem} from "../../components/AdminUserListItem.tsx";
import styles from "../../styles/UserProfile.module.css"
import {LoggedContainer} from "../LoggedContainer.tsx";
import {useEffect, useState} from "react";
import {action_admin_delete_user, action_admin_get_users} from "../../common/actions/actions.ts";
import {Spinner} from "../../components/Spinner.tsx";
import {UserData} from "../../common/actions/Responses.ts";
import {useToast} from "../../hooks/useToast.tsx";
import {useSelector} from "react-redux";
import {RootState} from "../../store/store.ts";

function AdminUserList() {
    const [loading, setLoading] = useState(true)
    const [users, setUsers] = useState<UserData[]>([]);
    const toast = useToast()
    const user = useSelector((state: RootState) => state.user)
    useEffect(() => {
        const _getUsers = async () => {
            const result = await action_admin_get_users()

            if (result.success) {
                // prevent showing current user in list
                const users = result.data.filter(el => el.id !== user.id)
                setUsers(users)
            }
            else{
                toast("Nie udało pobrać się użytkowników", "error");
            }
            setLoading(false)

        }
        _getUsers()
        document.body.classList.add(styles.userProfileBody)
        return () => {
            document.body.classList.remove(styles.userProfileBody)
        }
    }, [])

    const _handleUserDelete = async (userId: number) => {
        toast("Usuwanie użytkownika...", "info")
        const result = await action_admin_delete_user(userId)

        if(result.success){
            toast("Pomyślnie usunięto użytkownika")
            setUsers(items => items.filter(item => item.id !== userId))
        }else {
            toast("Nie udało się usunąć użytkownika", "error")
        }
    }

    return (
        <LoggedContainer>
            {loading && <Spinner/>}
            {!loading &&
                <div className={styles.container}>
                    {users.length === 0 && <div style={{textAlign:"center"}}>Brak użytkowników</div>}
                    {users.map(data => <AdminUserListItem key={data.id} name={data.name} id={data.id} surname={data.surname} avatar={data.profile.avatar} handleUserDelete={_handleUserDelete}/>)}
                </div>
            }
        </LoggedContainer>
    )
}

export {AdminUserList}