import React from 'react';
import { HashLink } from 'react-router-hash-link';

import '../Footer/_footer.css';


function Footer() {
    return (
    <div>
    <div className='footer'>
        <div className='col-3'>
            <HashLink to='/#banner' className='footer-logo'></HashLink>
        </div>
        <div className='footer-info col-8'>
            <h3>Our Partners</h3>
            <div className='partner-logo'>
                <div className='bc-logo'></div>
                <div className='idp-logo'></div>
            </div>
        </div>
        
    </div>
    <div className='footer-copy'>
        &copy; Copyright 2022 by LearningWithUs
    </div>
    </div>
  )
}

export default Footer