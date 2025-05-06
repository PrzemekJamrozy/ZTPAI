import {LoggedContainer} from "./LoggedContainer.tsx";
import styles from "../styles/Swiper.module.css"
import {useEffect, useState} from "react";
import {action_get_potential_matches} from "../common/actions/actions.ts";
import {UserData} from "../common/actions/Responses.ts";
import {useToast} from "../hooks/useToast.tsx";
import {Spinner} from "../components/Spinner.tsx";
function Swiper(){
    const [potentialMatches, setPotentialMatches] = useState<UserData[]>()
    const [loading, setLoading] = useState(true)
    const toast = useToast()
    useEffect(()=>{

        const _getPotentialMatches = async () => {
            const result = await action_get_potential_matches()

            if(result.success){
                setPotentialMatches(result.data)
            }else{
                toast("Błąd w pobieraniu listy użytkowników")
            }

            setLoading(false)
        }

        _getPotentialMatches()
        document.body.classList.add(styles.swiperBody)
        return () =>{
            document.body.classList.remove(styles.swiperBody)
        }
    },[])


    const _handleReject = () =>{

    }

    const _handleAccept = () =>{

    }
    return (
        <>
            <LoggedContainer>
                {loading && <Spinner/>}
                {!loading &&
                    <div className={styles.mainContainer}>
                        <div className={styles.profileCard}>
                            <img src="/uploads/placeholder.png" alt="Zdjęcie osoby" className="user-image"/>
                        </div>

                        <div className="info">
                            <p className={styles.username}></p>
                            <p className={styles.bio}></p>
                        </div>

                        <div className={styles.actionButtons}>
                            <button className={styles.actionButton} onClick={_handleReject}>
                                <img src="https://img.icons8.com/ios-filled/50/ffffff/delete-sign.png" alt="Odrzuć"/>
                            </button>
                            <button className={styles.actionButton} onClick={_handleAccept}>
                                <img src="https://img.icons8.com/ios-filled/50/ffffff/like.png" alt="Zainteresowany"/>
                            </button>
                        </div>
                    </div>
                }

            </LoggedContainer>
        </>
    )
}

export {Swiper}