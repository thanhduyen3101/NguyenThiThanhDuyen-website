import React from "react";

import '../Slide/_slideshow.css';
import imagesSlide from "./slideImage";
// const slideImages = [
//     '#ccc',
//     '#000',
//     'yellow'
// ];
const delay = 2500;

function SlideShow() {
    const [index, setIndex] = React.useState(0);
    const timeoutRef = React.useRef(null);


    function resetTimeout() {
        if (timeoutRef.current) {
          clearTimeout(timeoutRef.current);
        }
    }

    React.useEffect(() => {
        resetTimeout();
        timeoutRef.current = setTimeout(
          () =>
            setIndex((prevIndex) =>
              prevIndex === imagesSlide.length - 1 ? 0 : prevIndex + 1
            ),
          delay
        );
    
        return () => {
            resetTimeout();
        };
      }, [index]);

    return (
        <div className="slideshow">
            <div 
                className="slideshowSlider"
                style={{ transform: `translate3d(${-index * 100}%, 0, 0)` }}
            >
                {imagesSlide.map((image, index) => (
                    <div 
                        className="slide" 
                        key={index} 
                    ><img src={image}/></div>
                ))}
            </div>
        </div>
    )
} 

export default SlideShow;