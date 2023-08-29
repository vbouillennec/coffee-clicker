/* eslint-disable @typescript-eslint/no-unused-vars */
import { useEffect, useState } from "react";
import CoffeeCup from "./CoffeeCup";
import EmptyCoffeeCup from "./EmptyCoffeeCup";
import FullCoffeeCup from "./FullCoffeeCup";

const CoffeeLineUp = (props: { handleClick: () => void }) => {
    const [cups, setCups] = useState(calculateCups());
    const [half, setHalf] = useState(Math.floor(cups / 2));
    const [filledCups, setFilledCups] = useState(0);

    useEffect(() => {
        const setNewCupsCount = () => {
            const newCupsCount = calculateCups();

            setCups(newCupsCount);
            setHalf(Math.floor(newCupsCount / 2));
        };

        window.addEventListener("resize", setNewCupsCount);

        return () => {
            window.removeEventListener("resize", setNewCupsCount);
        };
    }, []);

    function calculateCups(): number {
        const cupWidth = 206;

        let count = Math.floor(window.innerWidth / cupWidth + 4);

        if (count % 2 === 0) return count + 1;

        return count;
    }

    return (
        <div className="flex flex-row gap-14">
            {Array.from(Array(cups).keys()).map((_, index) => {
                if (index < half) return <EmptyCoffeeCup key={index} />;
                if (index === half)
                    return (
                        <CoffeeCup
                            key={index}
                            setFilledCups={setFilledCups}
                            handleClick={props.handleClick}
                        />
                    );
                if (index > filledCups + half)
                    return <EmptyCoffeeCup key={index} />;
                return <FullCoffeeCup key={index} />;
            })}
        </div>
    );
};

export default CoffeeLineUp;
