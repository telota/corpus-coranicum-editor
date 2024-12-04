declare global {
  namespace NodeJS {
    interface ProcessEnv {
      MIX_APP_SUBPATH: string;
    }
  }
}

export {};