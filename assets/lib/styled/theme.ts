interface ThemeColors {
  primary: string;
  secondary: string;
}

interface ThemeShadows {
  close: string;
  far: string;
}

interface Theme {
  spacing: string;
  animationSpeed: string;
  colors: ThemeColors;
  shadows: ThemeShadows;
}

export const WordPressTheme: Theme = {
  spacing: "24px",
  animationSpeed: "300ms",
  colors: {
    primary: "#0071a1",
    secondary: "#ddd",
  },
  shadows: {
    close: "rgba(40, 40, 40, 0.3) 0 2px 2px",
    far: "rgba(40, 40, 40, 0.3) 0 4px 8px",
  },
};
