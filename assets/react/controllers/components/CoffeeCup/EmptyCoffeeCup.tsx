import "./CoffeeCup.css";

const EmptyCoffeeCup = () => {
    return (
        <div>
            <div className="empty-cup coffee-cup-container">
                <div className="empty-cup coffee-cup"></div>
                <div className="coffee-cup-handle"></div>
            </div>
        </div>
    );
};

export default EmptyCoffeeCup;
