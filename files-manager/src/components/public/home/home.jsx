import React from 'react';
import { Link } from 'react-router-dom';
import Header from '../home/header/header'
import Description from '../home/descriotion/description'
import Contact from '../home/contact/contact'

import Footer from '../home/footer/footer'

function Home() {
  return(
    <div>
    <Header  />
    <Description />
    <Contact/>
    <Footer  />
    </div>
  
  )
}

export default Home;
