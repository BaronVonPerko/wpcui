import styled from "styled-components";
import { WordPressTheme } from "./theme";

export const NotificationBox = styled.div`
  position: absolute;
  top: 0;
  right: 20px;
  padding: ${WordPressTheme.spacing};
  background-color: ${WordPressTheme.colors.primary};
  color: white;
  font-weight: bold;
  animation: fade-in ${WordPressTheme.animationSpeed} ease-in-out;
  box-shadow: ${WordPressTheme.shadows.close};
  transition: opacity ${WordPressTheme.animationSpeed} ease-in-out;
  opacity: ${(props) => (props.fade ? 0 : 1)};
`;

export const Card = styled.div`
  list-style: none;
  box-shadow: ${WordPressTheme.shadows.close};
  transition: all ${WordPressTheme.animationSpeed} ease-in-out;
  margin-bottom: ${WordPressTheme.spacing};
  animation: fade-in ${WordPressTheme.animationSpeed} ease-in-out;
`;

export const CardTitleSection = styled.div`
  display: flex;
  justify-content: space-between;
  align-items: center;
  h3 {
    display: inline-block;
  }
`;

export const CardStats = styled.div`
  text-align: center;
  margin-top: ${WordPressTheme.spacing};

  h5 {
    font-size: 24pt;
    font-weight: bold;
    margin: 0;
    color: rgba(0, 0, 0, 0.8);
  }

  p {
    color: rgba(0, 0, 0, 0.6);
  }
`;

export const TabPaneWrapper = styled.div`
  margin: ${WordPressTheme.spacing} 0;
`;

export const TabPaneTitles = styled.div`
  background-color: ${WordPressTheme.colors.secondary};
  display: flex;
  margin-bottom: ${WordPressTheme.spacing};
  margin: 0;
  padding: 0 12px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 600;
  text-align: center;
  transition: all 200ms ease-in-out;
  border-bottom: 4px solid ${WordPressTheme.colors.secondary};
`;

const TabPaneTitleActiveBorder = `4px solid ${WordPressTheme.colors.primary}`;
const TabPaneTitleBorder = `4px solid ${WordPressTheme.colors.secondary}`;
export const TabPaneTitle = styled.div`
  margin: 0;
  padding: 12px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 600;
  text-align: center;
  transition: all 200ms ease-in-out;
  border-bottom: ${(props) =>
    props.active ? TabPaneTitleActiveBorder : TabPaneTitleBorder};
`;

export const ModalWrapper = styled.div`
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.3);
  animation: fade-in ${WordPressTheme.animationSpeed} ease-in;
  z-index: 999;

  &div {
  }
`;

export const ModalContent = styled.div`
  width: 600px;
  margin: 300px auto 0;
  background-color: ${WordPressTheme.colors.secondary};
  padding: 20px 40px;
  border-radius: 4px;
  animation: modal-slide-in ${WordPressTheme.animationSpeed} ease-in;
  z-index: 1000;
`;
