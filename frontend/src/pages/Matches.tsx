import styles from "../styles/Matches.module.css"
import {useEffect, useState} from "react";
import {LoggedContainer} from "./LoggedContainer.tsx";
import {MatchItem} from "../components/MatchItem.tsx";
import {action_get_matches} from "../common/actions/actions.ts";
import {useToast} from "../hooks/useToast.tsx";
import {UserData} from "../common/actions/Responses.ts";
import {Spinner} from "../components/Spinner.tsx";


function Matches() {
    const [loading, setLoading] = useState(true);
    const [matches, setMatches] = useState<UserData[]>([]);
    const toast = useToast();
    useEffect(() => {

        const _getMatches = async () => {
            const result = await action_get_matches()

            if (result.success){
                setMatches(result.data)
            }else{
                toast("Nie udało się pobrać dopasowań", "error");
            }
            setLoading(false);
        }
        _getMatches()

        document.body.classList.add(styles.matchesBody);
        return () => {
            document.body.classList.remove(styles.matchesBody);
        };
    }, []);

    return (
        <>
                <LoggedContainer>
                    {loading && <Spinner/>}
                    {!loading && <>
                        <h1 className={styles.matchesHeader}>Osoby które też chcą się z tobą poznać</h1>
                        <div style={{marginLeft:16}}>{matches.map(data =>
                            <MatchItem key={data.id} imageUrl={data.profile.avatar} name={data.name} surname={data.surname} igLink={data.profile.igLink} fbLink={data.profile.fbLink}/>)}
                        {matches.length === 0 && <p>Nie masz jeszcze żadnych dopasowań</p>}</div>
                    </>
                    }

                </LoggedContainer>

        </>

    )
}

export {Matches}