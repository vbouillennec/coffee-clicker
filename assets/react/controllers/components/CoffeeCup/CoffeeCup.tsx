/* eslint-disable @typescript-eslint/no-unused-vars */
import anime from "animejs";
import "./CoffeeCup.css";
import { Dispatch, SetStateAction, useEffect, useState } from "react";

const INIT_POS_Y = 85;
const INIT_POS_X = 0;
const FILLING_PITCH = -16;
const WAVING_PITCH = 90;

const CoffeeCup = (props: {
    handleClick: () => void;
    setFilledCups: Dispatch<SetStateAction<number>>;
}) => {
    const [coffeeDrop, setCoffeeDrop] = useState(0);

    useEffect(() => {
        fillAnimation();
    }, [coffeeDrop]);

    const fillAnimation = () => {
        const wavingPx = coffeeDrop * WAVING_PITCH + INIT_POS_X;
        const fillingPx = coffeeDrop * FILLING_PITCH + INIT_POS_Y;

        anime({
            targets: ".current.coffee-cup",
            backgroundPosition: `${wavingPx}px ${fillingPx}px`,
            easing: "linear",
            duration: coffeeDrop === 0 ? 0 : 150,
            complete: () => {
                if (coffeeDrop > 7) newCoffeeCupAnimation();
            }
        });
    };

    const newCoffeeCupAnimation = () => {
        const newCoffeeAnim = anime({
            targets: ".coffee-cup-container",
            translateX: "206px",
            easing: "linear",
            duration: 200,
            complete: () => {
                setTimeout(() => {
                    newCoffeeAnim.restart();
                    newCoffeeAnim.pause();

                    setCoffeeDrop(0);
                    props.setFilledCups(c => c + 1);
                }, 0);
            }
        });
    };

    const clickOnCoffee = () => {
        if (coffeeDrop < 8) {
            props.handleClick();
            setCoffeeDrop(coffeeDrop + 1);
        }
    };

    return (
        <div className="flex flex-col justify-center">
            <div className={"coffee-cup-container"} onClick={clickOnCoffee}>
                <div
                    className={"current coffee-cup"}
                    style={{
                        backgroundPosition: `${INIT_POS_X}px ${INIT_POS_Y}px`
                    }}
                ></div>
                <div className="coffee-cup-handle"></div>
            </div>
            <h1 className="text-4xl font-extrabold dark:text-amber-950 coffee-level select-none">
                {~~coffeeDrop} oz
            </h1>
            <button
                id="click-me-button"
                style={{ transform: "scale(1)" }}
                className="bg-amber-800 hover:bg-amber-950 text-white font-bold py-2 px-4 border-b-4 border-amber-950 hover:border-black rounded"
                onClick={clickOnCoffee}
            >
                Fill coffee !
            </button>
        </div>
    );
};

export default CoffeeCup;
