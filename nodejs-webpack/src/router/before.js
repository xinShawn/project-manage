

import MP from "../managers/MP";

/**
 *
 * @param to
 * @param from
 * @param next
 */
let before = (to, from, next) => {
  
  try {

  } catch (e) {
    console.error(e);
  }
  
  next();
};

export default before;
