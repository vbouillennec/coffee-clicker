import Upgrades from "./Upgrades";
import { Upgrade } from "../interfaces/Upgrade";

function RightSide(props: {
    count: number;
    upgrades: Upgrade[];
    activeUpgrade: (index: number) => void;
    autoclickPerSecond: number;
}) {
    return (
        <div className="fixed w-200 top-0 right-0 p-6 flex flex-col gap-6">
            <Upgrades
                count={props.count}
                upgrades={props.upgrades}
                activeUpgrade={props.activeUpgrade}
                autoclickPerSecond={props.autoclickPerSecond}
            />
        </div>
    );
}

export default RightSide;
