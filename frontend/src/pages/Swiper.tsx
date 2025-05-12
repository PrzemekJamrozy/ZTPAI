import {LoggedContainer} from "./LoggedContainer.tsx";
import styles from "../styles/Swiper.module.css"
import {useEffect, useState} from "react";
import {action_accept_match, action_get_potential_matches, action_reject_match} from "../common/actions/actions.ts";
import {UserData} from "../common/actions/Responses.ts";
import {useToast} from "../hooks/useToast.tsx";
import {Spinner} from "../components/Spinner.tsx";
import BrokenHeart from "../assets/broken-heart.png"
import {useSelector} from "react-redux";
import {RootState} from "../store/store.ts";
import {UserStatusEnum} from "../common/enums/UserStatusEnum.ts";

function Swiper() {
    const [potentialMatches, setPotentialMatches] = useState<UserData[]>([])
    const [currentMatchIndex, setCurrentMatchIndex] = useState(0);
    const [loading, setLoading] = useState(true)
    const {status} = useSelector((root:RootState) => root.user)
    const toast = useToast()
    useEffect(() => {
        const _getPotentialMatches = async () => {
            if(status === UserStatusEnum.DURING_REGISTRATION){
                return
            }
            const result = await action_get_potential_matches()

            if (result.success) {
                setPotentialMatches(result.data)
            } else {
                toast("Błąd w pobieraniu listy użytkowników", "error")
            }

            setLoading(false)
        }

        _getPotentialMatches()
        document.body.classList.add(styles.swiperBody)
        return () => {
            document.body.classList.remove(styles.swiperBody)
        }
    }, [])

    const shiftMatchIndex = () => {
        setCurrentMatchIndex(currentMatchIndex + 1)
    }

    const _handleReject = async (userId: number) => {
        const result = await action_reject_match({idOfUserUserWantToMatch: userId})

        if (result.success) {
            shiftMatchIndex()
        } else {
            toast("Nie udało się dopasować użytkownika", "error")
        }
    }

    const _handleAccept = async (userId: number) => {
        const result = await action_accept_match({idOfUserUserWantToMatch: userId})

        if (result.success) {
            shiftMatchIndex()
        } else {
            toast("Nie udało się dopasować użytkownika", "error")
        }
    }

    return (
        <>
            <LoggedContainer>
                {loading && <Spinner/>}
                {!loading &&
                    <div className={styles.mainContainer}>
                        <div className={styles.profileCard}>
                            <img
                                src={currentMatchIndex === potentialMatches.length ? BrokenHeart : potentialMatches[currentMatchIndex].profile.avatar}
                                alt="Zdjęcie osoby" className="user-image"/>
                        </div>

                        <div className="info">
                            <p className={styles.username}>{currentMatchIndex === potentialMatches.length ? "Nie ma więcej dopasowań" : `${potentialMatches[currentMatchIndex].name} ${potentialMatches[currentMatchIndex].surname}`}</p>
                            <p className={styles.bio}>{currentMatchIndex === potentialMatches.length ? "Na ten moment nie mamy dla ciebie nowych dopasowań. Wróć później jak znajdziemy dla ciebie nowe dopasowania" : potentialMatches[currentMatchIndex].profile.bio}</p>
                        </div>

                        <div className={styles.actionButtons}>
                            <button className={styles.actionButton}
                                    onClick={() => currentMatchIndex === potentialMatches.length ? null : _handleReject(potentialMatches[currentMatchIndex].id)}>
                                <img src="https://img.icons8.com/ios-filled/50/ffffff/delete-sign.png" alt="Odrzuć"/>
                            </button>
                            <button className={styles.actionButton}
                                    onClick={() => currentMatchIndex === potentialMatches.length ? null : _handleAccept(potentialMatches[currentMatchIndex].id)}>
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